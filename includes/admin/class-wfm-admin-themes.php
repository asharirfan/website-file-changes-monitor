<?php
/**
 * WFM Admin Themes.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin Themes Class.
 *
 * This class monitors the theme install, uninstall, and
 * update events for file changes monitoring.
 */
class WFM_Admin_Themes {

	/**
	 * List of themes already installed.
	 *
	 * @var array
	 */
	private $old_themes = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		$has_permission = ( current_user_can( 'install_themes' ) || current_user_can( 'delete_themes' ) || current_user_can( 'update_themes' ) );

		if ( $has_permission ) {
			add_action( 'admin_init', array( $this, 'set_old_themes' ) );
			add_action( 'shutdown', array( $this, 'monitor_theme_events' ) );
		}
	}

	/**
	 * Set Old Themes.
	 */
	public function set_old_themes() {
		$this->old_themes = wp_get_themes();
	}

	/**
	 * Monitor Theme Events.
	 */
	public function monitor_theme_events() {
		global $pagenow;

		// Get $_POST action data.
		$action = isset( $_POST['action'] ) ? sanitize_text_field( wp_unslash( $_POST['action'] ) ) : false; // @codingStandardsIgnoreLine

		if ( 'update.php' === $pagenow ) {
			$action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : false; // @codingStandardsIgnoreLine
		}

		$install_actions = array( 'install-theme', 'upload-theme' );
		$update_actions  = array( 'upgrade-theme', 'update-theme', 'update-selected-themes' );

		// Handle theme install event.
		if ( in_array( $action, $install_actions, true ) && current_user_can( 'install_themes' ) ) {
			// Get installed theme.
			$themes = array_diff( wp_get_themes(), $this->old_themes );

			if ( ! empty( $themes ) ) {
				foreach ( $themes as $directory => $theme ) {
					wfm_add_site_theme( $directory );
				}
			}
		}

		// Handle theme uninstall event.
		if ( 'delete-theme' === $action && current_user_can( 'delete_themes' ) ) {
			foreach ( $this->get_removed_themes() as $theme ) {
				wfm_skip_theme_scan( $theme->stylesheet, 'uninstall' );
				wfm_remove_site_theme( $theme->stylesheet );
			}
		}

		// Handle theme update event.
		if ( in_array( $action, $update_actions, true ) && current_user_can( 'update_themes' ) && isset( $_POST['slug'] ) ) { // @codingStandardsIgnoreLine
			$updated_theme = sanitize_text_field( wp_unslash( $_POST['slug'] ) ); // @codingStandardsIgnoreLine

			if ( $updated_theme ) {
				wfm_skip_theme_scan( $updated_theme, 'update' );
			}
		}
	}

	/**
	 * Get removed themes.
	 *
	 * @return array of WP_Theme objects
	 */
	protected function get_removed_themes() {
		$removed_themes = $this->old_themes;
		foreach ( $removed_themes as $dir => $theme ) {
			if ( file_exists( $theme->get_template_directory() ) ) {
				unset( $removed_themes[ $dir ] );
			}
		}
		return array_values( $removed_themes );
	}
}

new WFM_Admin_Themes();
