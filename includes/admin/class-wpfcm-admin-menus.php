<?php
/**
 * Admin Menus.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin Admin Menus Class.
 */
class WPFCM_Admin_Menus {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
	}

	/**
	 * Add Plugin Admin Menu.
	 *
	 * Admin menu pages and sub-pages:
	 *
	 * 1. File Changes.
	 * 2. Settings.
	 * 3. Help & About.
	 */
	public function add_admin_menu() {
		add_menu_page( __( 'File Changes', 'wp-file-changes-monitor' ), __( 'File Changes', 'wp-file-changes-monitor' ), 'manage_options', 'wpfcm-file-changes', null, null, '20' );
		add_submenu_page( 'wpfcm-file-changes', __( 'File Changes', 'wp-file-changes-monitor' ), __( 'File Changes', 'wp-file-changes-monitor' ), 'manage_options', 'wpfcm-file-changes', array( $this, 'file_changes_page' ) );
		add_submenu_page( 'wpfcm-file-changes', __( 'Settings', 'wp-file-changes-monitor' ), __( 'Settings', 'wp-file-changes-monitor' ), 'manage_options', 'wpfcm-settings', array( $this, 'settings_page' ) );
		add_submenu_page( 'wpfcm-file-changes', __( 'Help & About', 'wp-file-changes-monitor' ), __( 'Help & About', 'wp-file-changes-monitor' ), 'manage_options', 'wpfcm-about', array( $this, 'about_page' ) );
	}

	/**
	 * File Changes Page.
	 */
	public function file_changes_page() {
		echo 'Hello, World';
	}

	/**
	 * Settings Page.
	 */
	public function settings_page() {
		echo 'Hello, World';
	}

	/**
	 * About Page.
	 */
	public function about_page() {
		echo 'Hello, World';
	}
}

new WPFCM_Admin_Menus();
