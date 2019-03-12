<?php
/**
 * Plugin Admin Class File.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin Class.
 *
 * Handles the admin side of the plugin.
 */
class WPFCM_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'include_admin_files' ) );
	}

	/**
	 * Include Admin Files.
	 */
	public function include_admin_files() {
		require_once trailingslashit( dirname( __FILE__ ) ) . 'class-wpfcm-admin-menus.php';
	}
}

new WPFCM_Admin();
