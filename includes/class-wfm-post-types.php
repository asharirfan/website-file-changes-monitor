<?php
/**
 * WFM Post Types.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WFM Post Type Class.
 *
 * This class handles registeration of post type and taxonomy
 * used by the plugin to store file notifications.
 */
class WFM_Post_Types {

	/**
	 * Initialize registration.
	 */
	public static function init() {
		// add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
	}

	/**
	 * Register Taxonomy.
	 */
	public static function register_taxonomy() {
		// Do action before registering taxonomy.
		do_action( 'wfm_register_event_taxonomy' );

		/**
		 * Event Type Taxonomy.
		 *
		 * Register taxonomy for event post type.
		 * Two terms of this taxonomy will be
		 * used to manage events.
		 *   1. Simple
		 *   2. Grouped
		 */
		register_taxonomy(
			'wfm_event_type',
			apply_filters( 'wfm_taxonomy_event_type_object', array( 'wfm_file_event' ) ),
			apply_filters(
				'wfm_taxonomy_event_type_args',
				array(
					'hierarchical'      => false,
					'show_ui'           => false,
					'show_in_nav_menus' => false,
					'query_var'         => is_admin(),
					'rewrite'           => false,
					'public'            => false,
				)
			)
		);

		// Do action after registering taxonomy.
		do_action( 'wfm_registered_event_taxonomy' );
	}

	/**
	 * Register Post Type.
	 */
	public static function register_post_type() {
		// Do action before registering post type.
		do_action( 'wfm_register_event_post_type' );

		/**
		 * Event Post Type.
		 *
		 * Register post type for file change events.
		 */
		register_post_type(
			'wfm_file_event',
			apply_filters(
				'wfm_register_event_post_type_args',
				array(
					'label'        => __( 'File Change Events', 'website-files-monitor' ),
					'public'       => false,
					'hierarchical' => false,
					'supports'     => false,
					'rewrite'      => false,
				)
			)
		);

		// Do action after registering post type.
		do_action( 'wfm_registered_event_post_type' );
	}
}

// Initialize post types.
WFM_Post_Types::init();
