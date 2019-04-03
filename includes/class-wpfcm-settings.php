<?php
/**
 * WPFCM Settings.
 *
 * @package wp-file-changes-monitor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WPFCM Settings Class.
 */
class WPFCM_Settings {

	/**
	 * Array of settings.
	 *
	 * @var array
	 */
	private static $settings = array();

	/**
	 * Return plugin setting.
	 *
	 * @param string $setting - Setting name.
	 * @param mixed  $default - Default setting value.
	 * @return mixed
	 */
	public static function get_setting( $setting, $default = false ) {
		if ( ! isset( self::$settings[ $setting ] ) ) {
			self::$settings[ $setting ] = get_option( WPFCM_OPT_PREFIX . $setting, $default );
		}

		return self::$settings[ $setting ];
	}

	/**
	 * Save plugin setting.
	 *
	 * @param string $setting - Setting name.
	 * @param mixed  $value   - Setting value.
	 */
	public static function save_setting( $setting, $value ) {
		update_option( WPFCM_OPT_PREFIX . $setting, $value );
		self::$settings[ $setting ] = $value;
	}

	/**
	 * Remove plugin setting.
	 *
	 * @param string $setting - Setting name.
	 */
	public static function delete_setting( $setting ) {
		delete_option( $setting );
		unset( self::$settings[ $setting ] );
	}

	/**
	 * Return the plugin settings.
	 *
	 * @return array
	 */
	public static function get_monitor_settings() {
		if ( ! is_multisite() ) {
			$default_dirs = array( 'root', 'wp-admin', 'wp-includes', 'wp-content', 'wp-content/themes', 'wp-content/plugins', 'wp-content/uploads' );
		} else {
			$default_dirs = array( 'root', 'wp-admin', 'wp-includes', 'wp-content', 'wp-content/themes', 'wp-content/plugins', 'wp-content/uploads', 'wp-content/uploads/sites' );
		}

		return array(
			'enabled'       => self::get_setting( 'keep-log', 'yes' ),
			'type'          => self::get_setting( 'scan-type', array( 'added', 'deleted', 'modified' ) ),
			'frequency'     => self::get_setting( 'scan-frequency', 'weekly' ),
			'hour'          => self::get_setting( 'scan-hour', '08' ),
			'day'           => self::get_setting( 'scan-day', '1' ),
			'date'          => self::get_setting( 'scan-date', '01' ),
			'directories'   => self::get_setting( 'scan-directories', $default_dirs ),
			'file-size'     => self::get_setting( 'scan-file-size', 10 ),
			'exclude-dirs'  => self::get_setting( 'scan-exclude-dirs', array( trailingslashit( WP_CONTENT_DIR ) . 'cache' ) ),
			'exclude-files' => self::get_setting( 'scan-exclude-files', array() ),
			'exclude-exts'  => self::get_setting( 'scan-exclude-exts', array( 'jpg', 'jpeg', 'png', 'bmp', 'pdf', 'txt', 'log', 'mo', 'po', 'mp3', 'wav', 'gif', 'ico', 'jpe', 'psd', 'raw', 'svg', 'tif', 'tiff', 'aif', 'flac', 'm4a', 'oga', 'ogg', 'ra', 'wma', 'asf', 'avi', 'mkv', 'mov', 'mp4', 'mpe', 'mpeg', 'mpg', 'ogv', 'qt', 'rm', 'vob', 'webm', 'wm', 'wmv' ) ),
		);
	}

	/**
	 * Add plugins or themes to site content setting.
	 *
	 * @param string $type    - Type of content i.e. `plugin` or `theme`.
	 * @param string $content - Name of the content. It can be a plugin or a theme.
	 */
	public static function set_site_content( $type, $content ) {
		// Set content option.
		$content_option = 'site_content';

		// Get site plugins options.
		$site_content = self::get_setting( $content_option, false );

		/**
		 * Initiate the content option.
		 *
		 * If option does not exists then set the option.
		 */
		if ( false === $site_content ) {
			$site_content = new stdClass(); // New stdClass object.
			$plugins      = wpfcm_get_site_plugins(); // Get plugins on the site.
			$themes       = wpfcm_get_site_themes(); // Get themes on the site.

			// Assign the plugins to content object.
			foreach ( $plugins as $index => $plugin ) {
				$site_content->plugins[]      = strtolower( $plugin );
				$site_content->skip_plugins[] = strtolower( $plugin );
			}

			// Assign the themes to content object.
			foreach ( $themes as $index => $theme ) {
				$site_content->themes[]      = strtolower( $theme );
				$site_content->skip_themes[] = strtolower( $theme );
			}

			self::save_setting( $content_option, $site_content );
		}

		// Check if type is plugin and content is not empty.
		if ( 'plugin' === $type && ! empty( $content ) ) {
			// If the plugin is not already present in the current list then.
			if ( ! in_array( $content, $site_content->plugins, true ) ) {
				// Add the plugin to the list and save it.
				$site_content->plugins[]      = strtolower( $content );
				$site_content->skip_plugins[] = strtolower( $content );
				self::save_setting( $content_option, $site_content );
			}
		} elseif ( 'theme' === $type && ! empty( $content ) ) {
			// If the theme is not already present in the current list then.
			if ( ! in_array( $content, $site_content->themes, true ) ) {
				// Add the theme to the list and save it.
				$site_content->themes[]      = strtolower( $content );
				$site_content->skip_themes[] = strtolower( $content );
				self::save_setting( $content_option, $site_content );
			}
		}
	}
}
