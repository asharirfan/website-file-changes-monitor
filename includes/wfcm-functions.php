<?php
/**
 * WFCM Settings File.
 *
 * @package wfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get all monitor settings.
 *
 * @return array
 */
function wfcm_get_monitor_settings() {
	if ( class_exists( 'WFCM_Settings' ) ) {
		return WFCM_Settings::get_monitor_settings();
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
function wfcm_get_setting( $setting, $default = '' ) {
	if ( class_exists( 'WFCM_Settings' ) ) {
		return WFCM_Settings::get_setting( $setting, $default );
	}
	return false;
}

/**
 * Save plugin setting.
 *
 * @param string $setting - Setting name.
 * @param mixed  $value   - Setting value.
 */
function wfcm_save_setting( $setting, $value ) {
	if ( class_exists( 'WFCM_Settings' ) ) {
		WFCM_Settings::save_setting( $setting, $value );
	}
}

/**
 * Delete plugin setting.
 *
 * @param string $setting - Setting name.
 */
function wfcm_delete_setting( $setting ) {
	if ( class_exists( 'WFCM_Settings' ) ) {
		WFCM_Settings::delete_setting( $setting );
	}
}

/**
 * Get site plugin directories.
 *
 * @return array
 */
function wfcm_get_site_plugins() {
	return array_map( 'dirname', array_keys( get_plugins() ) ); // Get plugin directories.
}

/**
 * Get site themes.
 *
 * @return array
 */
function wfcm_get_site_themes() {
	return array_keys( wp_get_themes() ); // Get themes.
}

/**
 * Initial Site Content Setup.
 *
 * Add plugins and themes to site content setting of the plugin.
 */
function wfcm_set_site_content() {
	// Get site plugins options.
	$site_content = wfcm_get_setting( WFCM_Settings::$site_content, false );

	// Initiate the site content option.
	if ( false === $site_content ) {
		// New stdClass object.
		$site_content = new stdClass();

		$plugins               = array_map( 'strtolower', wfcm_get_site_plugins() );
		$site_content->plugins = $plugins;

		foreach ( $plugins as $plugin ) {
			$site_content->skip_plugins[ $plugin ] = 'init';
		}

		$themes               = array_map( 'strtolower', wfcm_get_site_themes() );
		$site_content->themes = $themes;

		foreach ( $themes as $theme ) {
			$site_content->skip_themes[ $theme ] = 'init';
		}

		// Save site content.
		wfcm_save_setting( WFCM_Settings::$site_content, $site_content );
	}
}

/**
 * Add plugin(s) to site content plugins list.
 *
 * @param string $plugin - (Optional) Plugin directory name.
 */
function wfcm_add_site_plugin( $plugin = '' ) {
	WFCM_Settings::set_site_content( 'plugins', $plugin );
}

/**
 * Add theme(s) to site content themes list.
 *
 * @param string $theme - (Optional) Theme name.
 */
function wfcm_add_site_theme( $theme = '' ) {
	WFCM_Settings::set_site_content( 'themes', $theme );
}

/**
 * Remove plugin from site content plugins list.
 *
 * @param string $plugin - Plugin directory.
 */
function wfcm_remove_site_plugin( $plugin ) {
	WFCM_Settings::remove_site_content( 'plugins', $plugin );
}

/**
 * Remove theme from site content themes list.
 *
 * @param string $theme - Theme directory.
 */
function wfcm_remove_site_theme( $theme ) {
	WFCM_Settings::remove_site_content( 'themes', $theme );
}

/**
 * Skip plugin in the next file changes scan.
 *
 * @param string $plugin  - Plugin directory.
 * @param string $context - Context of the change, i.e., update or uninstall.
 */
function wfcm_skip_plugin_scan( $plugin, $context ) {
	WFCM_Settings::set_skip_site_content( 'plugins', $plugin, $context );
}

/**
 * Skip theme in the next file changes scan.
 *
 * @param string $theme   - Theme directory.
 * @param string $context - Context of the change, i.e., update or uninstall.
 */
function wfcm_skip_theme_scan( $theme, $context ) {
	WFCM_Settings::set_skip_site_content( 'themes', $theme, $context );
}

/**
 * Returns the instance of file changes montior.
 *
 * @return WFCM_Monitor
 */
function wfcm_get_monitor() {
	return WFCM_Monitor::get_instance();
}

/**
 * Create a new event.
 *
 * @param string $event_type - Event: added, modified, deleted.
 * @param string $file       - File.
 * @param string $file_hash  - File hash.
 */
function wfcm_create_event( $event_type, $file, $file_hash ) {
	// Create the content object.
	$content = (object) array(
		'file' => $file,
		'hash' => $file_hash,
	);

	// Create a new event object.
	$event = new WFCM_Event_File();
	$event->set_event_title( $file );      // Set event title.
	$event->set_event_type( $event_type ); // Set event type.
	$event->set_content( $content );       // Set event content.
	$event->save();                        // Save the event.
}

/**
 * Create a new directory event.
 *
 * @param string $event_type    - Event: added, modified, deleted.
 * @param string $directory     - Directory.
 * @param array  $content       - Array of directory contents.
 * @param string $event_context - (Optional) Event context.
 */
function wfcm_create_directory_event( $event_type, $directory, $content, $event_context = '' ) {
	// Create a new directory event object.
	$event = new WFCM_Event_Directory();

	// Set event data.
	$event->set_event_title( $directory );
	$event->set_event_type( $event_type );
	$event->set_content( $content );

	// Check for content type.
	if ( $event_context ) {
		$event->set_event_context( $event_context );
	}

	$event->save();
}

/**
 * Get events.
 *
 * @param array $args - Array of query arguments.
 * @return array|object
 */
function wfcm_get_events( $args ) {
	$query = new WFCM_Event_Query( $args );
	return $query->get_events();
}

/**
 * Get event object.
 *
 * @param int|WP_Post $the_event - ID or WP_Post object of an event.
 * @return WFCM_Event|array
 */
function wfcm_get_event( $the_event ) {
	// Get event id.
	if ( is_numeric( $the_event ) ) {
		$event_id = $the_event;
	} elseif ( $the_event instanceof WP_Post ) {
		$event_id = $the_event->ID;
	}

	// Get event content type.
	$content_type = WFCM_Data_Store::load( 'event' )->get_event_content_type( $event_id );

	if ( $content_type ) {
		$event_class = 'WFCM_Event_' . ucwords( $content_type );
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
function wfcm_get_events_for_js( $events ) {
	$js_events = array();

	if ( ! empty( $events ) && is_array( $events ) ) {
		foreach ( $events as $event ) {
			if ( ! $event instanceof WFCM_Event ) {
				continue;
			}

			$content_type  = $event->get_content_type();
			$event_context = 'directory' === $content_type ? $event->get_event_context() : '';

			$js_events[] = (object) array(
				'id'           => $event->get_event_id(),
				'path'         => dirname( $event->get_event_title() ),
				'filename'     => basename( $event->get_event_title() ),
				'content'      => $event->get_content(),
				'contentType'  => ucwords( $content_type ),
				'eventContext' => $event_context,
				'checked'      => false,
			);
		}
	}

	return $js_events;
}

/**
 * Install WFCM.
 *
 * Install routine that executes on every plugin update.
 */
function wfcm_install() {
	// WSAL plugins.
	$wsal_plugins = array( 'wp-security-audit-log/wp-security-audit-log.php', 'wp-security-audit-log-premium/wp-security-audit-log.php' );

	// Only run this when installing for the first time.
	if ( ! get_option( 'wfcm-version', false ) ) {
		foreach ( $wsal_plugins as $plugin ) {
			if ( is_plugin_active( $plugin ) ) {
				wfcm_save_setting( 'admin-notices', array( 'wsal' => true ) );
			}
		}
	}

	update_option( 'wfcm-version', wfcm_instance()->version );
	wfcm_set_site_content();
}
