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
}
