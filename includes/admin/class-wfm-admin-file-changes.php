<?php
/**
 * Admin File Changes View.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin file changes view class.
 */
class WFM_Admin_File_Changes {

	/**
	 * Page View.
	 */
	public static function output() {
		$suffix = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min'; // Check for debug mode.

		wp_enqueue_style(
			'wfm-file-changes-styles',
			WFM_BASE_URL . 'assets/css/dist/build.file-changes' . $suffix . '.css',
			array(),
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WFM_BASE_DIR . 'assets/css/dist/build.file-changes.css' ) : WFM_VERSION
		);

		wp_register_script(
			'wfm-file-changes',
			WFM_BASE_URL . 'assets/js/dist/file-changes' . $suffix . '.js',
			array( 'wp-element' ),
			( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? filemtime( WFM_BASE_DIR . 'assets/js/dist/file-changes.js' ) : WFM_VERSION,
			true
		);

		wp_localize_script(
			'wfm-file-changes',
			'wfmFileChanges',
			array(
				'security'   => wp_create_nonce( 'wp_rest' ),
				'fileEvents' => array(
					'get'    => esc_url_raw( rest_url( WFM_REST_NAMESPACE . WFM_REST_API::$events_base ) ),
					'delete' => esc_url_raw( rest_url( WFM_REST_NAMESPACE . WFM_REST_API::$events_base ) ),
				),
				'labels'     => array(
					'createdFiles'  => __( 'Created Files', 'website-files-monitor' ),
					'deletedFiles'  => __( 'Deleted Files', 'website-files-monitor' ),
					'modifiedFiles' => __( 'Modified Files', 'website-files-monitor' ),
				),
			)
		);

		wp_enqueue_script( 'wfm-file-changes' );
		?>
		<div class="wrap" id="wfm-file-changes-views"></div>
		<?php
	}
}
