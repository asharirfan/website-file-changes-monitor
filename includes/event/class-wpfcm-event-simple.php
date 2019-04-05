<?php
/**
 * WPFCM Simple Event.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WPFCM Simple Event Class.
 *
 * Handle the events of single files.
 */
class WPFCM_Event_Simple extends WPFCM_Event {

	/**
	 * Constructor.
	 *
	 * @param integer $event_id - (Optional) Event id.
	 */
	public function __construct( $event_id = 0 ) {
		$this->data['content_type'] = 'file'; // Content type.
		parent::__construct( $event_id );
	}

	/**
	 * Set content type.
	 *
	 * @param string $content_type - Content type.
	 * @return string
	 */
	public function set_content_type( $content_type ) {
		return $this->set_meta( 'content_type', $content_type );
	}

	/**
	 * Returns content type.
	 *
	 * @return string
	 */
	public function get_content_type() {
		return $this->get_meta( 'content_type' );
	}
}
