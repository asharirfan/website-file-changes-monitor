<?php
/**
 * Plugin Admin Class File.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin Class.
 *
 * Handles the admin side of the plugin.
 */
class WFM_Admin {

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
		require_once trailingslashit( dirname( __FILE__ ) ) . 'class-wfm-admin-menus.php';
		require_once trailingslashit( dirname( __FILE__ ) ) . 'class-wfm-admin-plugins.php';
		require_once trailingslashit( dirname( __FILE__ ) ) . 'class-wfm-admin-themes.php';
		require_once trailingslashit( dirname( __FILE__ ) ) . 'class-wfm-admin-system.php';
	}
}

new WFM_Admin();
