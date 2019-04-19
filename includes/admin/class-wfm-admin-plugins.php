<?php
/**
 * WFM Admin Plugins.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin Plugins Class.
 *
 * This class monitors the plugin install, uninstall, and
 * update events for file changes monitoring.
 */
class WFM_Admin_Plugins {

	/**
	 * List of plugins already installed.
	 *
	 * @var array
	 */
	private $old_plugins = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		$has_permission = ( current_user_can( 'install_plugins' ) || current_user_can( 'delete_plugins' ) || current_user_can( 'update_plugins' ) );

		// Only hook when handling AJAX request.
		if ( $has_permission && defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			add_action( 'admin_init', array( $this, 'set_old_plugins' ) );
			add_action( 'shutdown', array( $this, 'monitor_plugin_events' ) );
		}
	}

	/**
	 * Set Old Plugins.
	 */
	public function set_old_plugins() {
		$this->old_plugins = get_plugins();
	}

	/**
	 * Monitor Plugin Events.
	 */
	public function monitor_plugin_events() {
		// Get $_POST action data.
		$action = isset( $_POST['action'] ) ? sanitize_text_field( wp_unslash( $_POST['action'] ) ) : false; // @codingStandardsIgnoreLine

		$install_actions = array( 'install-plugin', 'upload-plugin' );
		$update_actions  = array( 'upgrade-plugin', 'update-plugin', 'update-selected' );

		// Handle plugin install event.
		if ( in_array( $action, $install_actions, true ) && current_user_can( 'install_plugins' ) ) {
			// Get installed plugin.
			$plugin       = array_values( array_diff( array_keys( get_plugins() ), array_keys( $this->old_plugins ) ) );
			$added_plugin = reset( $plugin );

			if ( false !== $added_plugin ) {
				wfm_add_site_plugin( dirname( $added_plugin ) );
			}
		}

		// Handle plugin uninstall event.
		if ( 'delete-plugin' === $action && current_user_can( 'delete_plugins' ) && isset( $_POST['plugin'] ) ) { // @codingStandardsIgnoreLine
			$deleted_plugin = sanitize_text_field( wp_unslash( $_POST['plugin'] ) ); // @codingStandardsIgnoreLine
			$deleted_plugin = dirname( $deleted_plugin );

			if ( $deleted_plugin ) {
				wfm_skip_plugin_scan( $deleted_plugin, 'uninstall' );
				wfm_remove_site_plugin( $deleted_plugin );
			}
		}

		// Handle plugin update event.
		if ( in_array( $action, $update_actions, true ) && current_user_can( 'update_plugins' ) && isset( $_POST['plugin'] ) ) { // @codingStandardsIgnoreLine
			$updated_plugin = sanitize_text_field( wp_unslash( $_POST['plugin'] ) ); // @codingStandardsIgnoreLine
			$updated_plugin = dirname( $updated_plugin );

			if ( $updated_plugin ) {
				wfm_skip_plugin_scan( $updated_plugin, 'update' );
			}
		}
	}
}

new WFM_Admin_Plugins();
