<?php
/**
 * WP File Changes Monitor.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Plugin Class.
 */
final class Website_Files_Monitor {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.0';

	/**
	 * Single instance of the plugin.
	 *
	 * @var Website_Files_Monitor
	 */
	protected static $instance = null;

	/**
	 * Main WP File Changes Monitor Instance.
	 *
	 * Ensures only one instance of WP File Changes Monitor is loaded or can be loaded.
	 *
	 * @return Website_Files_Monitor
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
		$this->register_hooks();
		do_action( 'website_files_monitor_loaded' );
	}

	/**
	 * Define constants.
	 */
	public function define_constants() {
		$this->define( 'WFM_VERSION', $this->version );
		$this->define( 'WFM_BASE_NAME', plugin_basename( WFM_PLUGIN_FILE ) );
		$this->define( 'WFM_BASE_URL', trailingslashit( plugin_dir_url( WFM_PLUGIN_FILE ) ) );
		$this->define( 'WFM_BASE_DIR', trailingslashit( plugin_dir_path( WFM_PLUGIN_FILE ) ) );
		$this->define( 'WFM_REST_NAMESPACE', 'website-files-monitor/v1' );
		$this->define( 'WFM_OPT_PREFIX', 'wfm-' );
		$this->define( 'WFM_MIN_PHP_VERSION', '5.5.0' );
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
		require_once WFM_BASE_DIR . 'includes/class-wfm-autoloader.php';
		require_once WFM_BASE_DIR . 'includes/wfm-functions.php';
		require_once WFM_BASE_DIR . 'includes/class-wfm-post-types.php';
		require_once WFM_BASE_DIR . 'includes/class-wfm-monitor.php';
		require_once WFM_BASE_DIR . 'includes/class-wfm-rest-api.php';

		// Data stores.
		require_once WFM_BASE_DIR . 'includes/class-wfm-data-store.php';
		require_once WFM_BASE_DIR . 'includes/data-stores/class-wfm-event-data-store.php';

		if ( is_admin() ) {
			require_once WFM_BASE_DIR . 'includes/admin/class-wfm-admin.php';
		}
	}

	/**
	 * Register Hooks.
	 */
	public function register_hooks() {
		register_activation_hook( WFM_PLUGIN_FILE, 'wfm_install' );
	}

	/**
	 * Error Logger
	 *
	 * Logs given input into debug.log file in debug mode.
	 *
	 * @param mixed $message - Error message.
	 */
	public function error_log( $message ) {
		if ( WP_DEBUG === true ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}
}
