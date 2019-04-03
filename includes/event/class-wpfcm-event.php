<?php
/**
 * WPFCM Event.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WPFCM Event Class.
 *
 * This is the base class for the file change events.
 */
class WPFCM_Event {

	/**
	 * Event ID.
	 *
	 * @var int
	 */
	protected $id = 0;

	/**
	 * Post Type.
	 *
	 * @var string
	 */
	protected $post_type = 'wpfcm_event';

	/**
	 * Event Data.
	 *
	 * @var array
	 */
	protected $data = array(
		'event_type'    => '',       // Added, modified, or deleted.
		'status'        => 'unread', // Event status.
		'resources'     => '',       // Resources.
		'resource_type' => '',       // Resource type. It can be file or directory.
	);

	/**
	 * Constructor.
	 *
	 * @param integer $event_id - (Optional) Event id.
	 */
	public function __construct( $event_id = 0 ) {
		if ( $event_id ) {
			$this->id = (int) $event_id;
		}
	}

	/**
	 * Save a new event.
	 *
	 * @param string $title       - Event title.
	 * @param string $event_type  - Type of event.
	 */
	public function save( $title, $event_type ) {
		$event_data = array(
			'post_type'   => $this->post_type,
			'post_title'  => $title,
			'post_status' => 'private',
		);

		$this->id = wp_insert_post( $event_data ); // Create a new event.

		$this->set_meta( 'event_type', $event_type );
		$this->set_meta( 'status', 'unread' );
	}

	/**
	 * Set Event Resources.
	 *
	 * @param string $resource_type - Resource type.
	 * @param array  $resources     - Array of resources.
	 */
	protected function set_resources( $resource_type, $resources ) {
		$this->set_meta( 'resource_type', $resource_type );
		$this->set_meta( 'resource_type', $resources );
	}

	/**
	 * Set Event Meta.
	 *
	 * @param string $key   - Meta key.
	 * @param mixed  $value - Meta value.
	 */
	protected function set_meta( $key, $value ) {
		$this->data[ $key ] = $value;
		update_post_meta( $this->id, $key, $value );
	}

	/**
	 * Get Event Meta.
	 *
	 * @param string $key - Meta key.
	 */
	protected function get_meta( $key ) {
		if ( empty( $this->data[ $key ] ) ) {
			$this->data[ $key ] = get_post_meta( $this->id, $key, true );
		}

		return $this->data[ $key ];
	}

	/**
	 * Returns event type.
	 *
	 * @return string
	 */
	public function get_event_type() {
		return $this->get_meta( 'event_type' );
	}

	/**
	 * Returns event status.
	 *
	 * @return string
	 */
	public function get_status() {
		return $this->get_meta( 'status' );
	}

	/**
	 * Returns resources.
	 *
	 * @return string
	 */
	public function get_resources() {
		return $this->get_meta( 'resources' );
	}

	/**
	 * Returns resource type.
	 *
	 * @return string
	 */
	public function get_resource_type() {
		return $this->get_meta( 'resource_type' );
	}
}
