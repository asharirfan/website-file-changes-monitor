<?php
/**
 * Plugin Name: WP File Changes Monitor
 * Plugin URI: http://www.wpwhitesecurity.com/
 * Description: Scan, detect, and log file changes on your WordPress website.
 * Author: WP White Security
 * Contributors: WP White Security, mrasharirfan
 * Version: 1.0
 * Text Domain: wp-file-changes-monitor
 * Author URI: http://www.wpwhitesecurity.com/
 * License: GPL3
 *
 * @package wpfcm
 */

/*
	WP File Changes Monitor
	Copyright(c) 2019  Robert Abela  (email : robert@wpwhitesecurity.com)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 3, as
	published by the Free Software Foundation.
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define plugin file.
if ( ! defined( 'WPFCM_PLUGIN_FILE' ) ) {
	define( 'WPFCM_PLUGIN_FILE', __FILE__ );
}

// Include main plugin class.
if ( ! class_exists( 'WP_File_Changes_Monitor' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-wp-file-changes-monitor.php';
}

/**
 * Main instance of WP File Changes Monitor.
 *
 * Returns the main instance of the plugin.
 *
 * @return WP_File_Changes_Monitor
 */
function wpfcm() {
	return WP_File_Changes_Monitor::instance();
}
wpfcm();
