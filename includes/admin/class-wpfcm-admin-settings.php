<?php
/**
 * Settings Class File.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin Settings Class.
 */
class WPFCM_Admin_Settings {

	/**
	 * Admin Messages.
	 *
	 * @var array
	 */
	private static $messages = array();

	/**
	 * Add Admin Message.
	 *
	 * @param string $message - Admin message.
	 */
	public static function add_message( $message ) {
		self::$messages[] = $message;
	}

	/**
	 * Show Admin Message.
	 */
	public static function show_messages() {
		if ( ! empty( self::$messages ) ) {
			foreach ( self::$messages as $message ) {
				echo '<div id="message" class="updated"><p><strong>' . esc_html( $message ) . '</strong></p></div>';
			}
		}
	}

	/**
	 * Initiate Settings Page.
	 */
	public static function output() {
		$suffix = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min'; // Check for debug mode.

		wp_enqueue_style(
			'wpfcm-settings-styles',
			WPFCM_BASE_URL . 'assets/css/dist/build.settings' . $suffix . '.css',
			array(),
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WPFCM_BASE_DIR . 'assets/css/dist/build.settings.css' ) : WPFCM_VERSION
		);

		wp_register_script(
			'wpfcm-settings',
			WPFCM_BASE_URL . 'assets/js/dist/settings' . $suffix . '.js',
			array(),
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WPFCM_BASE_DIR . 'assets/js/dist/settings.js' ) : WPFCM_VERSION,
			true
		);

		wp_localize_script(
			'wpfcm-settings',
			'wpfcmData',
			array(
				'monitor'          => array(
					'start' => esc_url_raw( rest_url( 'wp-file-changes-monitor/v1/monitor/start' ) ),
					'stop'  => esc_url_raw( rest_url( 'wp-file-changes-monitor/v1/monitor/stop' ) ),
				),
				'restRequestNonce' => wp_create_nonce( 'wp_rest' ),
				'scanButtons'      => array(
					'scanNow'    => esc_html__( 'Scan Now', 'wp-file-changes-monitor' ),
					'scanStop'   => esc_html__( 'Stop Scan', 'wp-file-changes-monitor' ),
					'scanning'   => esc_html__( 'Scanning...', 'wp-file-changes-monitor' ),
					'stopping'   => esc_html__( 'Stopping scan...', 'wp-file-changes-monitor' ),
					'scanFailed' => esc_html__( 'Scan Failed!', 'wp-file-changes-monitor' ),
				),
				'fileInvalid'      => esc_html__( 'Filename cannot be added because it contains invalid characters.', 'wp-file-changes-monitor' ),
				'extensionInvalid' => esc_html__( 'File extension cannot be added because it contains invalid characters.', 'wp-file-changes-monitor' ),
				'dirInvalid'       => esc_html__( 'Directory cannot be added because it contains invalid characters.', 'wp-file-changes-monitor' ),
			)
		);

		wp_enqueue_script( 'wpfcm-settings' );

		// Get plugin settings.
		$settings = wpfcm_get_monitor_settings();

		// Include the view file.
		require_once trailingslashit( dirname( __FILE__ ) ) . 'views/html-admin-settings.php';
	}

	/**
	 * Save Settings.
	 */
	public static function save() {
		check_admin_referer( 'wpfcm-save-admin-settings' );

		if ( isset( $_POST['wpfcm-settings'] ) ) {
			$wpfcm_settings = $_POST['wpfcm-settings']; // @codingStandardsIgnoreLine

			// This is to handle the empty exclude list case.
			$exclude_settings = array(
				'scan-exclude-dirs'  => array(),
				'scan-exclude-files' => array(),
				'scan-exclude-exts'  => array(),
			);
			$wpfcm_settings   = wp_parse_args( $wpfcm_settings, $exclude_settings );

			foreach ( $wpfcm_settings as $key => $value ) {
				if ( is_array( $value ) ) {
					$value = array_map( 'sanitize_text_field', wp_unslash( $value ) );
				} else {
					$value = sanitize_text_field( wp_unslash( $value ) );
				}

				if ( 'scan-exclude-dirs' === $key ) {
					$value = array_filter( $value, array( __CLASS__, 'filter_exclude_directory' ) );
				}

				$exclude_settings = array( 'scan-exclude-dirs', 'scan-exclude-exts', 'scan-exclude-files' );

				if ( in_array( $key, $exclude_settings, true ) ) {
					self::set_skip_monitor_content( $key, $value );
				}

				wpfcm_save_setting( $key, $value );
			}

			self::add_message( __( 'Your settings have been saved.', 'wp-file-changes-monitor' ) );
		}
	}

	/**
	 * Filter Excluded Directories.
	 *
	 * @param string $directory - Excluded directory.
	 * @return string
	 */
	private static function filter_exclude_directory( $directory ) {
		// Get uploads directory.
		$uploads_dir = wp_upload_dir();

		// Server directories.
		$server_dirs = array(
			untrailingslashit( ABSPATH ), // Root directory.
			ABSPATH . 'wp-admin',         // WordPress Admin.
			ABSPATH . WPINC,              // wp-includes.
			WP_CONTENT_DIR,               // wp-content.
			WP_CONTENT_DIR . '/themes',   // Themes.
			WP_PLUGIN_DIR,                // Plugins.
			$uploads_dir['basedir'],      // Uploads.
		);

		if ( '/' === substr( $directory, -1 ) ) {
			$directory = untrailingslashit( $directory );
		}

		if ( ! in_array( $directory, $server_dirs, true ) ) {
			return $directory;
		}
	}

	/**
	 * Set Skip Monitor Content.
	 *
	 * Set skip content for file changes scan to avoid useless notifications.
	 *
	 * @param string $setting - Setting name.
	 * @param array  $value   - Setting value.
	 */
	private static function set_skip_monitor_content( $setting, $value ) {
		$site_content = new stdClass();
		$site_content = wpfcm_get_setting( WPFCM_Settings::$site_content, $site_content );

		$stored_setting  = wpfcm_get_setting( $setting, array() );
		$removed_content = array_diff( $stored_setting, $value );

		if ( ! empty( $removed_content ) ) {
			$type         = str_replace( 'scan-exclude-', '', $setting );
			$content_type = "skip_$type";

			if ( isset( $site_content->$content_type ) ) {
				array_merge( $site_content->$content_type, $removed_content );
			} else {
				$site_content->$content_type = $removed_content;
			}

			wpfcm_save_setting( WPFCM_Settings::$site_content, $site_content );
		}
	}
}
