<?php
/**
 * WPFCM API.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WPFCM API Class.
 *
 * This class registers and handles the REST API requests of the plugin.
 */
class WPFCM_API {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_monitor_rest_routes' ) );
		add_action( 'rest_api_init', array( $this, 'register_events_rest_routes' ) );
	}

	/**
	 * Register Rest Route for Scanning.
	 */
	public function register_monitor_rest_routes() {
		// Start scan route.
		register_rest_route(
			'wp-file-changes-monitor/v1',
			'/monitor/start',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'scan_start' ),
				'permission_callback' => function() {
					return current_user_can( 'manage_options' );
				},
			)
		);

		// Stop scan route.
		register_rest_route(
			'wp-file-changes-monitor/v1',
			'/monitor/stop',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'scan_stop' ),
				'permission_callback' => function() {
					return current_user_can( 'manage_options' );
				},
			)
		);
	}

	/**
	 * Register Rest Route for Scanning.
	 */
	public function register_events_rest_routes() {
		// Start scan route.
		register_rest_route(
			'wp-file-changes-monitor/v1',
			'/monitor-events/created',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_created_events' ),
				'permission_callback' => function() {
					return current_user_can( 'manage_options' );
				},
			)
		);
	}

	/**
	 * REST API callback for start scan request.
	 *
	 * @return boolean
	 */
	public function scan_start() {
		// Run a manual scan of all directories.
		for ( $dir = 0; $dir < 7; $dir++ ) {
			if ( ! $this->check_scan_stop() ) {
				wpfcm_get_monitor()->scan_file_changes( true, $dir );
			} else {
				break;
			}
		}

		wpfcm_delete_setting( 'scan-stop' );
		return true;
	}

	/**
	 * REST API callback for stop scan request.
	 *
	 * @return boolean
	 */
	public function scan_stop() {
		wpfcm_save_setting( 'scan-stop', true );
		return true;
	}

	/**
	 * Check if scan stop flag option is set.
	 *
	 * @return string|null
	 */
	private function check_scan_stop() {
		global $wpdb;
		$options_table = $wpdb->prefix . 'options';
		return $wpdb->get_var( "SELECT option_value FROM $options_table WHERE option_name = 'wpfcm-scan-stop'" ); // phpcs: ignore
	}

	/**
	 * REST API callback for fetching created file events.
	 *
	 * @return string - JSON string of events.
	 */
	public function get_created_events() {
		$created_events = array(
			(object) array(
				'id'       => 1,
				'path'     => ABSPATH,
				'filename' => 'hello.php',
			),
			(object) array(
				'id'       => 2,
				'path'     => ABSPATH,
				'filename' => 'wp-hello.php',
			),
		);

		return wp_json_encode( $created_events );
	}
}

new WPFCM_API();
