<?php
/**
 * WFM REST API.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WFM REST API Class.
 *
 * This class registers and handles the REST API requests of the plugin.
 */
class WFM_REST_API {

	/**
	 * Monitor events base.
	 *
	 * @var string
	 */
	public static $monitor_base = '/monitor';

	/**
	 * Events base.
	 *
	 * @var string
	 */
	public static $events_base = '/monitor-events';

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
			WFM_REST_NAMESPACE,
			self::$monitor_base . '/start',
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
			WFM_REST_NAMESPACE,
			self::$monitor_base . '/stop',
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
		// Register rest route for getting events.
		register_rest_route(
			WFM_REST_NAMESPACE,
			self::$events_base . '/(?P<event_type>[\S]+)',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_events' ),
				'permission_callback' => function() {
					return current_user_can( 'manage_options' );
				},
				'validate_callback'   => function( $param ) {
					return in_array( $param, array( 'added', 'deleted', 'modified' ), true );
				},
			)
		);

		// Register rest route for removing an event.
		register_rest_route(
			WFM_REST_NAMESPACE,
			self::$events_base . '/(?P<event_id>[\d]+)',
			array(
				'methods'             => WP_REST_Server::DELETABLE,
				'callback'            => array( $this, 'delete_event' ),
				'permission_callback' => function() {
					return current_user_can( 'manage_options' );
				},
				'validate_callback'   => function( $param ) {
					return is_numeric( $param );
				},
				'args'                => array(
					'exclude' => array(
						'type'        => 'boolean',
						'default'     => false,
						'description' => __( 'Whether to exclude the content in future scans or not', 'website-files-monitor' ),
					),
				),
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
				wfm_get_monitor()->scan_file_changes( true, $dir );
			} else {
				break;
			}
		}

		wfm_delete_setting( 'scan-stop' );
		return true;
	}

	/**
	 * REST API callback for stop scan request.
	 *
	 * @return boolean
	 */
	public function scan_stop() {
		wfm_save_setting( 'scan-stop', true );
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
		return $wpdb->get_var( "SELECT option_value FROM $options_table WHERE option_name = 'wfm-scan-stop'" ); // phpcs:ignore
	}

	/**
	 * REST API callback for fetching created file events.
	 *
	 * @param WP_Rest_Request $rest_request - Rest request object.
	 * @return string - JSON string of events.
	 */
	public function get_events( $rest_request ) {
		// Get event params from request object.
		$event_type = $rest_request->get_param( 'event_type' );
		$paged      = $rest_request->get_param( 'paged' );

		if ( ! $event_type ) {
			return new WP_Error( 'empty_event_type', __( 'No event type specified for the request.', 'website-files-monitor' ), array( 'status' => 404 ) );
		}

		// Set events query arguments.
		$event_args = array(
			'status'         => 'unread',
			'event_type'     => $event_type,
			'posts_per_page' => 5,
			'paginate'       => true,
			'paged'          => $paged,
		);

		// Query events.
		$events_query = wfm_get_events( $event_args );

		// Convert events for JS response.
		$events_query->events = wfm_get_events_for_js( $events_query->events );

		$response = new WP_REST_Response( $events_query );
		$response->set_status( 200 );

		return $response;
	}

	/**
	 * REST API callback for marking events as read.
	 *
	 * @param WP_Rest_Request $rest_request - Rest request object.
	 * @return WP_Rest_Request
	 */
	public function delete_event( $rest_request ) {
		// Get event id from request.
		$event_id = $rest_request->get_param( 'event_id' );

		if ( ! $event_id ) {
			return new WP_Error( 'empty_event_id', __( 'No event id specified for the request.', 'website-files-monitor' ), array( 'status' => 404 ) );
		}

		// Get request body to check if event is excluded.
		$request_body = $rest_request->get_body();
		$request_body = json_decode( $request_body );
		$is_excluded  = isset( $request_body->exclude ) ? $request_body->exclude : false;

		if ( $is_excluded ) {
			// Get event content type.
			$event        = wfm_get_event( $event_id );
			$content_type = $event->get_content_type();

			if ( 'file' === $content_type ) {
				$excluded_content   = wfm_get_setting( 'scan-exclude-files', array() );
				$excluded_content[] = basename( $event->get_event_title() );
				wfm_save_setting( 'scan-exclude-files', $excluded_content );
			} elseif ( 'directory' === $content_type ) {
				$excluded_content   = wfm_get_setting( 'scan-exclude-dirs', array() );
				$excluded_content[] = $event->get_event_title();
				wfm_save_setting( 'scan-exclude-dirs', $excluded_content );
			}
		}

		// Delete the event.
		if ( wp_delete_post( $event_id, true ) ) {
			$response = array( 'success' => true );
		} else {
			$response = array( 'success' => false );
		}

		$response = new WP_REST_Response( $response );
		$response->set_status( 200 );

		return $response;
	}
}

new WFM_REST_API();
