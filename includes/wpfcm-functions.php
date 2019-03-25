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
