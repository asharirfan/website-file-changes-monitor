<?php
/**
 * Admin Menus.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin Admin Menus Class.
 */
class WFM_Admin_Menus {

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
	 * 1. Files Monitor.
	 * 2. Settings.
	 * 3. Help & About.
	 */
	public function add_admin_menu() {
		add_menu_page( __( 'Files Monitor', 'website-files-monitor' ), __( 'Files Monitor', 'website-files-monitor' ), 'manage_options', 'wfm-file-changes', null, null, '20' );
		add_submenu_page( 'wfm-file-changes', __( 'Files Monitor', 'website-files-monitor' ), __( 'Files Monitor', 'website-files-monitor' ), 'manage_options', 'wfm-file-changes', array( $this, 'file_changes_page' ) );
	}

	/**
	 * Add Settings Menu.
	 */
	public function settings_menu() {
		$settings_page = add_submenu_page( 'wfm-file-changes', __( 'Files Monitor Settings', 'website-files-monitor' ), __( 'Settings', 'website-files-monitor' ), 'manage_options', 'wfm-settings', array( $this, 'settings_page' ) );
		add_action( "load-$settings_page", array( $this, 'settings_page_init' ) );
	}

	/**
	 * Add About Menu.
	 */
	public function about_menu() {
		add_submenu_page( 'wfm-file-changes', __( 'Help & About', 'website-files-monitor' ), __( 'Help & About', 'website-files-monitor' ), 'manage_options', 'wfm-about', array( $this, 'about_page' ) );
	}

	/**
	 * Files Monitor Page.
	 */
	public function file_changes_page() {
		WFM_Admin_File_Changes::output();
	}

	/**
	 * Settings Page.
	 */
	public function settings_page() {
		WFM_Admin_Settings::output();
	}

	/**
	 * Settings Page Initialized.
	 */
	public function settings_page_init() {
		if ( ! empty( $_POST['submit'] ) ) { // @codingStandardsIgnoreLine
			WFM_Admin_Settings::save();
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

		$events_count = wp_count_posts( 'wfm_file_event' );

		if ( isset( $events_count->private ) && $events_count->private ) {
			$count_html = '<span class="update-plugins"><span class="events-count">' . $events_count->private . '</span></span>';

			foreach ( $menu as $key => $value ) {
				if ( 'wfm-file-changes' === $menu[ $key ][2] ) {
					$menu[ $key ][0] .= ' ' . $count_html; // phpcs:ignore
					break;
				}
			}
		}
	}
}

new WFM_Admin_Menus();
