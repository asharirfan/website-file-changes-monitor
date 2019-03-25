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
		$settings = WPFCM_Settings::get_monitor_settings();

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
				WPFCM_Settings::save_setting( $key, $value );
			}
		}
	}
}
