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
		self::settings_page();
	}

	/**
	 * Settings Page.
	 */
	public static function settings_page() {
		// Include the view file.
		require_once trailingslashit( dirname( __FILE__ ) ) . 'views/html-admin-settings.php';
	}
}
