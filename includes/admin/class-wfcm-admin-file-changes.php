<?php
/**
 * Admin File Changes View.
 *
 * @package wfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin file changes view class.
 */
class WFCM_Admin_File_Changes {

	/**
	 * Admin messages.
	 *
	 * @var array
	 */
	private static $messages = array();

	/**
	 * Allowed HTML.
	 *
	 * @var array
	 */
	private static $allowed_html = array(
		'a'      => array(
			'href'   => array(),
			'target' => array(),
		),
		'strong' => array(),
		'ul'     => array(),
		'li'     => array(),
		'p'      => array(),
	);

	/**
	 * Add admin message.
	 *
	 * @param string $key     - Message key.
	 * @param string $type    - Type of message.
	 * @param string $message - Admin message.
	 */
	public static function add_message( $key, $type, $message ) {
		self::$messages[ $key ] = array(
			'type'    => $type,
			'message' => $message,
		);
	}

	/**
	 * Add specific page messages.
	 */
	public static function add_messages() {
		// Get file limits message setting.
		$monitor_limits_msgs = wfcm_get_setting( 'admin-notices', array() );

		if ( ! empty( $monitor_limits_msgs ) ) {
			if ( isset( $monitor_limits_msgs['files-limit'] ) && ! empty( $monitor_limits_msgs['files-limit'] ) ) {
				// Append strong tag to each directory name.
				$dirs = array_reduce(
					$monitor_limits_msgs['files-limit'],
					function( $dirs, $dir ) {
						array_push( $dirs, "<li><strong>$dir</strong></li>" );
						return $dirs;
					},
					array()
				);

				$msg = '<p>' . sprintf(
					/* Translators: %s: WP White Security support hyperlink. */
					__( 'The plugin stopped scanning the below directories because they have more than 1 million files. Please contact %s for assistance.', 'website-file-changes-monitor' ),
					'<a href="mailto:support@wpwhitesecurity.com" target="_blank">' . __( 'our support', 'website-file-changes-monitor' ) . '</a>'
				) . '</p>';
				$msg .= '<ul>' . implode( '', $dirs ) . '</ul>';

				self::add_message( 'files-limit', 'warning', $msg );
			}

			if ( isset( $monitor_limits_msgs['filesize-limit'] ) && ! empty( $monitor_limits_msgs['filesize-limit'] ) ) {
				// Append strong tag to each directory name.
				$files = array_reduce(
					$monitor_limits_msgs['filesize-limit'],
					function( $files, $file ) {
						array_push( $files, "<li><strong>$file</strong></li>" );
						return $files;
					},
					array()
				);

				$msg = '<p>' . sprintf(
					/* Translators: %s: Plugin settings hyperlink. */
					__( 'These files are bigger than 5MB and have not been scanned. To scan them increase the file size scan limit from the %s.', 'website-file-changes-monitor' ),
					'<a href="' . add_query_arg( 'page', 'wfcm-settings', admin_url( 'admin.php' ) ) . '">' . __( 'plugin settings', 'website-file-changes-monitor' ) . '</a>'
				) . '</p>';
				$msg .= '<ul>' . implode( '', $files ) . '</ul>';

				self::add_message( 'filesize-limit', 'warning', $msg );
			}
		}
	}

	/**
	 * Show admin message.
	 */
	public static function show_messages() {
		if ( ! empty( self::$messages ) ) {
			$messages = apply_filters( 'wfcm_admin_file_changes_messages', self::$messages );
			foreach ( $messages as $key => $notice ) :
				?>
				<div id="wfcm-admin-notice-<?php echo esc_attr( $key ); ?>" class="notice notice-<?php echo esc_attr( $notice['type'] ); ?> wfcm-admin-notice is-dismissible">
					<?php echo wp_kses( $notice['message'], self::$allowed_html ); ?>
				</div>
				<?php
			endforeach;
		}
	}

	/**
	 * Page View.
	 */
	public static function output() {
		// Add notifications to the view.
		self::add_messages();

		$wp_version        = get_bloginfo( 'version' );
		$suffix            = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min'; // Check for debug mode.
		$wfcm_dependencies = array();

		wp_enqueue_style(
			'wfcm-file-changes-styles',
			WFCM_BASE_URL . 'assets/css/dist/build.file-changes' . $suffix . '.css',
			array(),
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WFCM_BASE_DIR . 'assets/css/dist/build.file-changes.css' ) : WFCM_VERSION
		);

		// For WordPress versions earlier than 5.0, enqueue react and react-dom from the vendors directory.
		if ( version_compare( $wp_version, '5.0', '<' ) ) {
			wp_enqueue_script(
				'wfcm-react',
				WFCM_BASE_URL . 'assets/js/dist/vendors/react.min.js',
				array(),
				'16.6.3',
				true
			);

			wp_enqueue_script(
				'wfcm-react-dom',
				WFCM_BASE_URL . 'assets/js/dist/vendors/react-dom.min.js',
				array(),
				'16.6.3',
				true
			);

			$wfcm_dependencies = array( 'wfcm-react', 'wfcm-react-dom' );
		} else {
			// Otherwise enqueue WordPress' react library.
			$wfcm_dependencies = array( 'wp-element' );
		}

		wp_register_script(
			'wfcm-file-changes',
			WFCM_BASE_URL . 'assets/js/dist/file-changes' . $suffix . '.js',
			$wfcm_dependencies,
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WFCM_BASE_DIR . 'assets/js/dist/file-changes.js' ) : WFCM_VERSION,
			true
		);

		wp_localize_script(
			'wfcm-file-changes',
			'wfcmFileChanges',
			array(
				'security'    => wp_create_nonce( 'wp_rest' ),
				'fileEvents'  => array(
					'get'    => esc_url_raw( rest_url( WFCM_REST_NAMESPACE . WFCM_REST_API::$events_base ) ),
					'delete' => esc_url_raw( rest_url( WFCM_REST_NAMESPACE . WFCM_REST_API::$events_base ) ),
				),
				'pageHead'    => __( 'Website File Changes Monitor', 'website-file-changes-monitor' ),
				'labels'      => array(
					'addedFiles'    => __( 'Added Files', 'website-file-changes-monitor' ),
					'deletedFiles'  => __( 'Deleted Files', 'website-file-changes-monitor' ),
					'modifiedFiles' => __( 'Modified Files', 'website-file-changes-monitor' ),
				),
				'bulkActions' => array(
					'screenReader' => __( 'Select bulk action', 'website-file-changes-monitor' ),
					'bulkActions'  => __( 'Bulk Actions', 'website-file-changes-monitor' ),
					'markAsRead'   => __( 'Mark as Read', 'website-file-changes-monitor' ),
					'exclude'      => __( 'Exclude', 'website-file-changes-monitor' ),
					'apply'        => __( 'Apply', 'website-file-changes-monitor' ),
				),
				'tableHead'   => array(
					'path'       => __( 'Path', 'website-file-changes-monitor' ),
					'name'       => __( 'Name', 'website-file-changes-monitor' ),
					'type'       => __( 'Type', 'website-file-changes-monitor' ),
					'markAsRead' => __( 'Mark as Read', 'website-file-changes-monitor' ),
					'exclude'    => __( 'Exclude from scans', 'website-file-changes-monitor' ),
				),
			)
		);

		wp_enqueue_script( 'wfcm-file-changes' );

		// Display notifications of the view.
		self::show_messages();
		?>
		<div class="wrap" id="wfcm-file-changes-view"></div>
		<?php
	}
}
