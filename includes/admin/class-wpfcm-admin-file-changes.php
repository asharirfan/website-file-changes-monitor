<?php
/**
 * Admin File Changes View.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin file changes view class.
 */
class WPFCM_Admin_File_Changes {

	/**
	 * Page View.
	 */
	public static function output() {
		$suffix = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min'; // Check for debug mode.

		wp_register_script(
			'wpfcm-file-changes',
			WPFCM_BASE_URL . 'assets/js/dist/file-changes.js',
			array( 'wp-element' ),
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WPFCM_BASE_DIR . 'assets/js/dist/file-changes.js' ) : WPFCM_VERSION,
			true
		);

		wp_localize_script(
			'wpfcm-file-changes',
			'wpfcmFileChanges',
			array(
				'security'   => wp_create_nonce( 'wp_rest' ),
				'fileEvents' => array(
					'get'    => esc_url_raw( rest_url( WPFCM_REST_NAMESPACE . WPFCM_API::$events_base ) ),
					'delete' => esc_url_raw( rest_url( WPFCM_REST_NAMESPACE . WPFCM_API::$events_base ) ),
				),
				'labels'     => array(
					'createdFiles'  => __( 'Created Files', 'wp-file-changes-monitor' ),
					'deletedFiles'  => __( 'Deleted Files', 'wp-file-changes-monitor' ),
					'modifiedFiles' => __( 'Modified Files', 'wp-file-changes-monitor' ),
				),
			)
		);

		wp_enqueue_script( 'wpfcm-file-changes' );
		?>
		<div class="wrap" id="wpfcm-file-changes-views">
			<!-- <h1>Hello, World!</h1> -->
		</div>
		<?php
	}
}
