<?php
/**
 * Plugin Name: Website Files Monitor
 * Plugin URI: http://www.wpwhitesecurity.com/
 * Description: Scan, detect, and log file changes on your WordPress website.
 * Author: WP White Security
 * Contributors: WP White Security, mrasharirfan
 * Version: 1.0
 * Text Domain: website-files-monitor
 * Author URI: http://www.wpwhitesecurity.com/
 * License: GPL3
 *
 * @package wfm
 */

/*
	Website Files Monitor
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
if ( ! defined( 'WFM_PLUGIN_FILE' ) ) {
	define( 'WFM_PLUGIN_FILE', __FILE__ );
}

// Include main plugin class.
if ( ! class_exists( 'Website_Files_Monitor' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-website-files-monitor.php';
}

/**
 * Main instance of Website Files Monitor.
 *
 * Returns the main instance of the plugin.
 *
 * @return Website_Files_Monitor
 */
function wfm_instance() {
	return Website_Files_Monitor::instance();
}
wfm_instance();
