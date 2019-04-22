<?php
/**
 * Plugin Admin Class File.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin Class.
 *
 * Handles the admin side of the plugin.
 */
class WFM_Admin {

	/**
	 * Plugin Admin Notices.
	 *
	 * @var array
	 */
	private static $admin_notices = array();

	/**
	 * Allowed HTML.
	 *
	 * @var array
	 */
	private static $allowed_html = array(
		'a' => array(
			'href'   => array(),
			'target' => array(),
		),
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->set_admin_notices();
		add_action( 'init', array( $this, 'include_admin_files' ) );
		add_action( 'admin_notices', array( $this, 'show_wfm_admin_notices' ) );
		add_action( 'admin_footer', array( $this, 'admin_footer_scripts' ) );
	}

	/**
	 * Set admin notices.
	 */
	private function set_admin_notices() {
		self::$admin_notices = apply_filters(
			'wfm_admin_notices',
			array(
				'wsal' => array(
					'type'    => 'warning',
					'message' => sprintf(
						/* Translators: WordPress file scanning hyperlink */
						__( 'We noticed that the WP Security Audit Log plugin is installed on this website. WP Security Audit Log also alerts you of file changes on your website. Therefore we recommend you to either disable the %s or deactivate this plugin.', 'website-files-monitor' ),
						'<a href="https://www.wpsecurityauditlog.com/support-documentation/wordpress-files-changes-warning-activity-logs/" target="_blank">' . __( 'WordPress file scanning on WP Security Audit Log plugin', 'website-files-monitor' ) . '</a>'
					),
				),
			)
		);
	}

	/**
	 * Include Admin Files.
	 */
	public function include_admin_files() {
		require_once trailingslashit( dirname( __FILE__ ) ) . 'class-wfm-admin-menus.php';
		require_once trailingslashit( dirname( __FILE__ ) ) . 'class-wfm-admin-plugins.php';
		require_once trailingslashit( dirname( __FILE__ ) ) . 'class-wfm-admin-themes.php';
		require_once trailingslashit( dirname( __FILE__ ) ) . 'class-wfm-admin-system.php';
	}

	/**
	 * Show plugin admin notices (if any).
	 */
	public function show_wfm_admin_notices() {
		// Get admin notices option.
		$admin_notices = wfm_get_setting( 'admin-notices', array() );

		foreach ( $admin_notices as $notice_key => $notice_value ) {
			if ( isset( self::$admin_notices[ $notice_key ] ) && $notice_value ) {
				$this->display_notice( $notice_key, self::$admin_notices[ $notice_key ] );
			}
		}
	}

	/**
	 * Display notice.
	 *
	 * @param string $id     - Notice id.
	 * @param string $notice - Message to display in notice.
	 */
	private function display_notice( $id, $notice ) {
		?>
		<div id="wfm-admin-notice-<?php echo esc_attr( $id ); ?>" class="notice notice-<?php echo esc_attr( $notice['type'] ); ?> wfm-admin-notice">
			<p><?php echo wp_kses( $notice['message'], self::$allowed_html ); ?></p>
			<p><input class="button" type="button" data-notice-id="<?php echo esc_attr( $id ); ?>" value="<?php esc_attr_e( 'OK', 'website-files-monitor' ); ?>"></p>
		</div>
		<?php
	}

	/**
	 * Render admin footer scripts (if needed).
	 */
	public function admin_footer_scripts() {
		// Get admin notices option.
		$admin_notices = wfm_get_setting( 'admin-notices', array() );

		$render_js = false;

		foreach ( $admin_notices as $notice_key => $notice_value ) {
			if ( isset( self::$admin_notices[ $notice_key ] ) && $notice_value ) {
				$render_js = true;
				break;
			}
		}

		if ( $render_js ) {
			$suffix = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min'; // Check for debug mode.

			wp_register_script(
				'wfm-common',
				WFM_BASE_URL . 'assets/js/dist/common' . $suffix . '.js',
				array(),
				( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WFM_BASE_DIR . 'assets/js/dist/common.js' ) : WFM_VERSION,
				true
			);

			wp_localize_script(
				'wfm-common',
				'wfmData',
				array(
					'restNonce'         => wp_create_nonce( 'wp_rest' ),
					'restAdminEndpoint' => rest_url( WFM_REST_NAMESPACE . WFM_REST_API::$admin_notices ),
				)
			);

			wp_enqueue_script( 'wfm-common' );
		}
	}
}

new WFM_Admin();
