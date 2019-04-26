<?php
/**
 * About page.
 *
 * @package wfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * About page class.
 */
class WFCM_Admin_About {

	/**
	 * Page tabs.
	 *
	 * @var array
	 */
	private static $tabs = array();

	/**
	 * Set tabs of the page.
	 */
	private static function set_tabs() {
		self::$tabs = apply_filters(
			'wfcm_admin_about_page_tabs',
			array(
				'help'        => array(
					'title' => __( 'Help', 'website-file-changes-monitor' ),
					'link'  => self::get_page_url(),
					'view'  => 'html-admin-help.php',
				),
				'about'       => array(
					'title' => __( 'About', 'website-file-changes-monitor' ),
					'link'  => add_query_arg( 'tab', 'about', self::get_page_url() ),
					'view'  => 'html-admin-about.php',
				),
				'system-info' => array(
					'title' => __( 'System Info', 'website-file-changes-monitor' ),
					'link'  => add_query_arg( 'tab', 'system-info', self::get_page_url() ),
					'view'  => 'html-admin-system-info.php',
				),
			)
		);
	}

	/**
	 * Get active tab.
	 *
	 * @return string
	 */
	private static function get_active_tab() {
		return isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'help'; // phpcs:ignore
	}

	/**
	 * Return page url.
	 *
	 * @return string
	 */
	public static function get_page_url() {
		return add_query_arg( 'page', 'wfcm-about', admin_url( 'admin.php' ) );
	}

	/**
	 * Display the page.
	 */
	public static function output() {
		self::set_tabs();

		$suffix = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min'; // Check for debug mode.

		wp_enqueue_style(
			'wfcm-settings-styles',
			WFCM_BASE_URL . 'assets/css/dist/build.settings' . $suffix . '.css',
			array(),
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WFCM_BASE_DIR . 'assets/css/dist/build.settings.css' ) : WFCM_VERSION
		);

		require_once trailingslashit( dirname( __FILE__ ) ) . 'views/html-admin-about-wrapper.php';
	}
}
