<?php
/**
 * WPFCM Settings File.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get WP File Changes Monitor Settings.
 *
 * @return array
 */
function wpfcm_get_monitor_settings() {
	if ( class_exists( 'WPFCM_Settings' ) ) {
		return WPFCM_Settings::get_monitor_settings();
	}
	return array();
}

/**
 * Get plugin setting.
 *
 * @param string $setting - Setting name.
 * @param mixed  $default - Default value.
 * @return mixed
 */
function wpfcm_get_setting( $setting, $default = '' ) {
	if ( class_exists( 'WPFCM_Settings' ) ) {
		return WPFCM_Settings::get_setting( $setting, $default );
	}
	return false;
}

/**
 * Save plugin setting.
 *
 * @param string $setting - Setting name.
 * @param mixed  $value   - Setting value.
 */
function wpfcm_save_setting( $setting, $value ) {
	if ( class_exists( 'WPFCM_Settings' ) ) {
		WPFCM_Settings::save_setting( $setting, $value );
	}
}

/**
 * Delete plugin setting.
 *
 * @param string $setting - Setting name.
 */
function wpfcm_delete_setting( $setting ) {
	if ( class_exists( 'WPFCM_Settings' ) ) {
		WPFCM_Settings::delete_setting( $setting );
	}
}

/**
 * Get site plugin directories.
 *
 * @return array
 */
function wpfcm_get_site_plugins() {
	return array_map( 'dirname', array_keys( get_plugins() ) ); // Get plugin directories.
}

/**
 * Get site themes.
 *
 * @return array
 */
function wpfcm_get_site_themes() {
	return array_keys( wp_get_themes() ); // Get themes.
}

/**
 * Initial Site Content Setup.
 *
 * Add plugins and themes to site content setting of the plugin.
 */
function wpfcm_set_site_content() {
	// Get site plugins options.
	$site_content = wpfcm_get_setting( WPFCM_Settings::$site_content, false );

	// Initiate the site content option.
	if ( false === $site_content ) {
		// New stdClass object.
		$site_content = new stdClass();

		$plugins                    = array_map( 'strtolower', wpfcm_get_site_plugins() );
		$site_content->plugins      = $plugins;
		$site_content->skip_plugins = $plugins;

		$themes                    = array_map( 'strtolower', wpfcm_get_site_themes() );
		$site_content->themes      = $themes;
		$site_content->skip_themes = $themes;

		// Save site content.
		wpfcm_save_setting( WPFCM_Settings::$site_content, $site_content );
	}
}

/**
 * Add plugin(s) to site content plugins list.
 *
 * @param string $plugin - (Optional) Plugin directory name.
 */
function wpfcm_add_site_plugin( $plugin = '' ) {
	WPFCM_Settings::set_site_content( 'plugins', $plugin );
}

/**
 * Add theme(s) to site content themes list.
 *
 * @param string $theme - (Optional) Theme name.
 */
function wpfcm_add_site_theme( $theme = '' ) {
	WPFCM_Settings::set_site_content( 'themes', $theme );
}

/**
 * Remove plugin from site content plugins list.
 *
 * @param string $plugin - Plugin directory.
 */
function wpfcm_remove_site_plugin( $plugin ) {
	WPFCM_Settings::remove_site_content( 'plugins', $plugin );
}

/**
 * Remove theme from site content themes list.
 *
 * @param string $theme - Theme directory.
 */
function wpfcm_remove_site_theme( $theme ) {
	WPFCM_Settings::remove_site_content( 'themes', $theme );
}

/**
 * Skip plugin in the next file changes scan.
 *
 * @param string $plugin - Plugin directory.
 */
function wpfcm_skip_plugin_scan( $plugin ) {
	WPFCM_Settings::set_skip_site_content( 'plugins', $plugin );
}

/**
 * Skip theme in the next file changes scan.
 *
 * @param string $theme - Theme directory.
 */
function wpfcm_skip_theme_scan( $theme ) {
	WPFCM_Settings::set_skip_site_content( 'themes', $theme );
}

/**
 * Returns the instance of file changes montior.
 *
 * @return WPFCM_Monitor
 */
function wpfcm_get_monitor() {
	return WPFCM_Monitor::get_instance();
}

/**
 * Create a new event.
 *
 * @param string $event_type - Event: added, modified, deleted.
 * @param string $file       - File.
 * @param string $file_hash  - File hash.
 */
function wpfcm_create_event( $event_type, $file, $file_hash ) {
	// Create the content object.
	$content = (object) array(
		'file' => $file,
		'hash' => $file_hash,
	);

	// Create a new event object.
	$event = new WPFCM_Event_File();
	$event->set_event_title( $file );      // Set event title.
	$event->set_event_type( $event_type ); // Set event type.
	$event->set_content( $content );       // Set event content.
	$event->save();                        // Save the event.
}

/**
 * Create a new directory event.
 *
 * @param string $event_type - Event: added, modified, deleted.
 * @param string $directory  - Directory.
 * @param array  $content    - Array of directory contents.
 */
function wpfcm_create_directory_event( $event_type, $directory, $content ) {
	// Create a new directory event object.
	$event = new WPFCM_Event_Directory();
	$event->set_event_title( $directory );
	$event->set_event_type( $event_type );
	$event->set_content( $content );
	$event->save();
}

/**
 * Get events.
 *
 * @param array $args - Array of query arguments.
 * @return array|object
 */
function wpfcm_get_events( $args ) {
	$query = new WPFCM_Event_Query( $args );
	return $query->get_events();
}

/**
 * Get event object.
 *
 * @param int|WP_Post $the_event - ID or WP_Post object of an event.
 * @return WPFCM_Event|array
 */
function wpfcm_get_event( $the_event ) {
	// Get event id.
	if ( is_numeric( $the_event ) ) {
		$event_id = $the_event;
	} elseif ( $the_event instanceof WP_Post ) {
		$event_id = $the_event->ID;
	}

	// Get event content type.
	$content_type = WPFCM_Data_Store::load( 'event' )->get_event_content_type( $event_id );

	if ( $content_type ) {
		$event_class = 'WPFCM_Event_' . ucwords( $content_type );
		return new $event_class( $the_event );
	}

	return array();
}

/**
 * Get events for JS.
 *
 * Returns an array of objects with these properties:
 *   - id: Event id.
 *   - path: Event content path.
 *   - filename: Event content name.
 *
 * @param array $events - Array of events.
 * @return array
 */
function wpfcm_get_events_for_js( $events ) {
	$js_events = array();

	if ( ! empty( $events ) && is_array( $events ) ) {
		foreach ( $events as $event ) {
			if ( ! $event instanceof WPFCM_Event ) {
				continue;
			}

			$js_events[] = (object) array(
				'id'       => $event->get_event_id(),
				'path'     => dirname( $event->get_event_title() ),
				'filename' => basename( $event->get_event_title() ),
				'checked'  => false,
			);
		}
	}

	return $js_events;
}
