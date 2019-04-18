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
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 10 );
		add_action( 'admin_menu', array( $this, 'settings_menu' ), 20 );
		add_action( 'admin_menu', array( $this, 'about_menu' ), 30 );
		add_action( 'admin_menu', array( $this, 'add_events_count' ), 40 );
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
	}

	/**
	 * Add Settings Menu.
	 */
	public function settings_menu() {
		$settings_page = add_submenu_page( 'wpfcm-file-changes', __( 'File Changes Settings', 'wp-file-changes-monitor' ), __( 'Settings', 'wp-file-changes-monitor' ), 'manage_options', 'wpfcm-settings', array( $this, 'settings_page' ) );
		add_action( "load-$settings_page", array( $this, 'settings_page_init' ) );
	}

	/**
	 * Add About Menu.
	 */
	public function about_menu() {
		add_submenu_page( 'wpfcm-file-changes', __( 'Help & About', 'wp-file-changes-monitor' ), __( 'Help & About', 'wp-file-changes-monitor' ), 'manage_options', 'wpfcm-about', array( $this, 'about_page' ) );
	}

	/**
	 * File Changes Page.
	 */
	public function file_changes_page() {
		WPFCM_Admin_File_Changes::output();
	}

	/**
	 * Settings Page.
	 */
	public function settings_page() {
		WPFCM_Admin_Settings::output();
	}

	/**
	 * Settings Page Initialized.
	 */
	public function settings_page_init() {
		if ( ! empty( $_POST['submit'] ) ) { // @codingStandardsIgnoreLine
			WPFCM_Admin_Settings::save();
		}
	}

	/**
	 * About Page.
	 */
	public function about_page() {
		echo 'Hello, World';
	}

	/**
	 * Add events count to menu.
	 */
	public function add_events_count() {
		global $menu;

		$events_count = wp_count_posts( 'wpfcm_file_event' );

		if ( isset( $events_count->private ) && $events_count->private ) {
			$count_html = '<span class="update-plugins"><span class="events-count">' . $events_count->private . '</span></span>';

			foreach ( $menu as $key => $value ) {
				if ( 'wpfcm-file-changes' === $menu[ $key ][2] ) {
					$menu[ $key ][0] .= ' ' . $count_html; // phpcs:ignore
					break;
				}
			}
		}
	}
}

new WPFCM_Admin_Menus();
