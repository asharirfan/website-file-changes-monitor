<?php
/**
 * Admin Menus.
 *
 * @package wfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin Admin Menus Class.
 */
class WFCM_Admin_Menus {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 10 );
		add_action( 'admin_menu', array( $this, 'settings_menu' ), 20 );
		add_action( 'admin_menu', array( $this, 'about_menu' ), 30 );
		add_action( 'admin_menu', array( $this, 'add_events_count' ), 40 );

		add_action( 'admin_print_styles', array( $this, 'admin_styles' ) );
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
		add_menu_page(
			__( 'Website File Changes Monitor', 'website-file-changes-monitor' ),
			__( 'Files Monitor', 'website-file-changes-monitor' ),
			'manage_options',
			'wfcm-file-changes',
			null,
			WFCM_BASE_URL . 'assets/img/wfcm-menu-icon.svg',
			'75'
		);

		add_submenu_page( 'wfcm-file-changes', __( 'Website File Changes Monitor', 'website-file-changes-monitor' ), __( 'Files Monitor', 'website-file-changes-monitor' ), 'manage_options', 'wfcm-file-changes', array( $this, 'file_changes_page' ) );
	}

	/**
	 * Add Settings Menu.
	 */
	public function settings_menu() {
		$settings_page = add_submenu_page( 'wfcm-file-changes', __( 'Settings', 'website-file-changes-monitor' ), __( 'Settings', 'website-file-changes-monitor' ), 'manage_options', 'wfcm-settings', array( $this, 'settings_page' ) );
		add_action( "load-$settings_page", array( $this, 'settings_page_init' ) );
	}

	/**
	 * Add About Menu.
	 */
	public function about_menu() {
		add_submenu_page( 'wfcm-file-changes', __( 'Help & About', 'website-file-changes-monitor' ), __( 'Help & About', 'website-file-changes-monitor' ), 'manage_options', 'wfcm-about', array( $this, 'about_page' ) );
	}

	/**
	 * Files Monitor Page.
	 */
	public function file_changes_page() {
		WFCM_Admin_File_Changes::output();
	}

	/**
	 * Settings Page.
	 */
	public function settings_page() {
		WFCM_Admin_Settings::output();
	}

	/**
	 * Settings Page Initialized.
	 */
	public function settings_page_init() {
		if ( ! empty( $_POST['submit'] ) ) { // @codingStandardsIgnoreLine
			WFCM_Admin_Settings::save();
		}
	}

	/**
	 * About Page.
	 */
	public function about_page() {
		WFCM_Admin_About::output();
	}

	/**
	 * Add events count to menu.
	 */
	public function add_events_count() {
		global $menu;

		$events_count = wp_count_posts( 'wfcm_file_event' );

		if ( isset( $events_count->private ) && $events_count->private ) {
			$count_html = '<span class="update-plugins"><span class="events-count">' . $events_count->private . '</span></span>';

			foreach ( $menu as $key => $value ) {
				if ( 'wfcm-file-changes' === $menu[ $key ][2] ) {
					$menu[ $key ][0] .= ' ' . $count_html; // phpcs:ignore
					break;
				}
			}
		}
	}

	/**
	 * Print admin styles.
	 */
	public function admin_styles() {
		?>
		<style>#adminmenu .toplevel_page_wfcm-file-changes .wp-menu-image img { padding: 5px 0 0 0; }</style>
		<?php
	}
}

new WFCM_Admin_Menus();
