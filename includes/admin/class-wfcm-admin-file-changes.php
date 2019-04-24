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
	 * Page View.
	 */
	public static function output() {
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
				'security'   => wp_create_nonce( 'wp_rest' ),
				'fileEvents' => array(
					'get'    => esc_url_raw( rest_url( WFCM_REST_NAMESPACE . WFCM_REST_API::$events_base ) ),
					'delete' => esc_url_raw( rest_url( WFCM_REST_NAMESPACE . WFCM_REST_API::$events_base ) ),
				),
				'labels'     => array(
					'createdFiles'  => __( 'Created Files', 'website-file-changes-monitor' ),
					'deletedFiles'  => __( 'Deleted Files', 'website-file-changes-monitor' ),
					'modifiedFiles' => __( 'Modified Files', 'website-file-changes-monitor' ),
				),
			)
		);

		wp_enqueue_script( 'wfcm-file-changes' );
		?>
		<div class="wrap" id="wfcm-file-changes-view"></div>
		<?php
	}
}
