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
function wpfcm_get_settings() {
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

