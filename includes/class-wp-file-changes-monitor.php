<?php
/**
 * WP File Changes Monitor.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Plugin Class.
 */
final class WP_File_Changes_Monitor {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.0';

	/**
	 * Single instance of the plugin.
	 *
	 * @var WP_File_Changes_Monitor
	 */
	protected static $instance = null;

	/**
	 * Main WP File Changes Monitor Instance.
	 *
	 * Ensures only one instance of WP File Changes Monitor is loaded or can be loaded.
	 *
	 * @return WP_File_Changes_Monitor
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Contructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		do_action( 'wp_file_changes_monitor_loaded' );
	}

	/**
	 * Define constants.
	 */
	public function define_constants() {
		$this->define( 'WPFCM_VERSION', $this->version );
		$this->define( 'WPFCM_BASE_NAME', plugin_basename( WPFCM_PLUGIN_FILE ) );
		$this->define( 'WPFCM_BASE_URL', trailingslashit( plugin_dir_url( WPFCM_PLUGIN_FILE ) ) );
		$this->define( 'WPFCM_BASE_DIR', trailingslashit( plugin_dir_path( WPFCM_PLUGIN_FILE ) ) );
		$this->define( 'WPFCM_OPT_PREFIX', 'wpfcm-' );
		$this->define( 'WPFCM_MIN_PHP_VERSION', '5.5.0' );
	}

	/**
	 * Define constant if not defined already.
	 *
	 * @param string $name  - Constant name.
	 * @param string $value - Constant value.
	 */
	public function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include plugin files.
	 */
	public function includes() {
		require_once WPFCM_BASE_DIR . 'includes/class-wpfcm-autoloader.php';
	}
}
