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
	 * Return the plugin settings.
	 *
	 * @return array
	 */
	public static function get_settings() {
		if ( ! is_multisite() ) {
			$default_dirs = array( 'root', 'wp-admin', 'wp-includes', 'wp-content', 'wp-content/themes', 'wp-content/plugins', 'wp-content/uploads' );
		} else {
			$default_dirs = array( 'root', 'wp-admin', 'wp-includes', 'wp-content', 'wp-content/themes', 'wp-content/plugins', 'wp-content/uploads', 'wp-content/uploads/sites' );
		}

		return array(
			'enabled'       => self::get_option( 'keep-log', 'yes' ),
			'type'          => self::get_option( 'scan-type', array( 'added', 'deleted', 'modified' ) ),
			'frequency'     => self::get_option( 'scan-frequency', 'weekly' ),
			'hour'          => self::get_option( 'scan-hour', '08' ),
			'day'           => self::get_option( 'scan-day', '1' ),
			'date'          => self::get_option( 'scan-date', '01' ),
			'directories'   => self::get_option( 'scan-directories', $default_dirs ),
			'file-size'     => self::get_option( 'scan-file-size', 10 ),
			'exclude-dirs'  => self::get_option( 'scan-exclude-dirs', array( trailingslashit( WP_CONTENT_DIR ) . 'cache' ) ),
			'exclude-files' => self::get_option( 'scan-exclude-files', array() ),
			'exclude-exts'  => self::get_option( 'scan-exclude-exts', array( 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'txt', 'log', 'mo', 'po', 'mp3', 'wav', 'gif', 'ico', 'jpe', 'psd', 'raw', 'svg', 'tif', 'tiff', 'aif', 'flac', 'm4a', 'oga', 'ogg', 'ra', 'wma', 'asf', 'avi', 'mkv', 'mov', 'mp4', 'mpe', 'mpeg', 'mpg', 'ogv', 'qt', 'rm', 'vob', 'webm', 'wm', 'wmv' ) ),
		);
	}

	/**
	 * Return plugin option.
	 *
	 * @param string $option  - Option name.
	 * @param mixed  $default - Default option value.
	 * @return mixed
	 */
	public static function get_option( $option, $default ) {
		return get_option( WPFCM_OPT_PREFIX . $option, $default );
	}

	/**
	 * Save plugin option.
	 *
	 * @param string $option - Option name.
	 * @param mixed  $value  - Option value.
	 */
	public static function save_option( $option, $value ) {
		update_option( WPFCM_OPT_PREFIX . $option, $value );
	}

	/**
	 * Initiate Settings Page.
	 */
	public static function output() {
		$suffix = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min'; // Check for debug mode.

		wp_enqueue_style(
			'wpfcm-settings-styles',
			WPFCM_BASE_URL . 'assets/css/style' . $suffix . '.css',
			array(),
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WPFCM_BASE_DIR . 'assets/css/style.css' ) : WPFCM_VERSION
		);

		wp_register_script(
			'wpfcm-settings',
			WPFCM_BASE_URL . 'assets/js/custom' . $suffix . '.js',
			array( 'jquery' ),
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WPFCM_BASE_DIR . 'assets/js/custom.js' ) : WPFCM_VERSION,
			true
		);

		wp_localize_script(
			'wpfcm-settings', 'wpfcmData', array(
				'fileInvalid'      => esc_html__( 'Filename cannot be added because it contains invalid characters.', 'wp-file-changes-monitor' ),
				'extensionInvalid' => esc_html__( 'File extension cannot be added because it contains invalid characters.', 'wp-file-changes-monitor' ),
				'dirInvalid'       => esc_html__( 'Directory cannot be added because it contains invalid characters.', 'wp-file-changes-monitor' ),
			)
		);

		wp_enqueue_script( 'wpfcm-settings' );

		// Get plugin settings.
		$settings = self::get_settings();

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

			foreach ( $wpfcm_settings as $key => $value ) {
				if ( is_array( $value ) ) {
					$value = array_map( 'sanitize_text_field', wp_unslash( $value ) );
				} else {
					$value = sanitize_text_field( wp_unslash( $value ) );
				}
				self::save_option( $key, $value );
			}
		}
	}
}
