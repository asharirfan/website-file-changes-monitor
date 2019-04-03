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
		return WPFCM_Settings::save_setting( $setting, $value );
	}
}

/**
 * Create a new event.
 *
 * @param string $type      - Type of event: added, modified, deleted.
 * @param string $file      - File.
 * @param string $file_hash - File hash.
 */
function wpfcm_create_event( $type, $file, $file_hash ) {
	// Create a resource object.
	$data = (object) array(
		'file' => $file,
		'hash' => $file_hash,
	);

	$event = new WPFCM_Event();
	$event->save( $file, $type );
	$event->set_resources( 'file', $data );
}

/**
 * Get site plugin directories.
 *
 * @return array
 */
function wpfcm_get_site_plugins() {
	return array_map( 'wpfcm_get_dirname', array_keys( get_plugins() ) ); // Remove php file name from the plugins.
}

/**
 * Get directory name.
 *
 * @param string $plugin - Plugin name.
 * @return string
 */
function wpfcm_get_dirname( $plugin ) {
	return dirname( $plugin );
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
 * Add plugin(s) to site plugins list.
 *
 * @param string $plugin - Plugin directory name.
 */
function wpfcm_set_site_plugins( $plugin = '' ) {
	WPFCM_Settings::set_site_content( 'plugin', $plugin );
}

