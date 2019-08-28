<?php
/**
 * About tab.
 *
 * @package wfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$plugins_data = array(
	array(
		'img'  => trailingslashit( WFCM_BASE_URL ) . 'assets/img/about/wp-security-audit-log-img.jpg',
		'desc' => __( 'Keep a log of users & under the hood activity on WordPress', 'website-file-changes-monitor' ),
		'alt'  => 'WP Security Audit Log',
		'link' => 'https://www.wpsecurityauditlog.com/?utm_source=plugin&utm_medium=wsal&utm_campaign=xpromo',
	),
	array(
		'img'  => trailingslashit( WFCM_BASE_URL ) . 'assets/img/about/password-policy-manager.jpg',
		'desc' => __( 'Enforce strong password policies on your WordPress websites', 'website-file-changes-monitor' ),
		'alt'  => 'Password Policy Manager',
		'link' => 'https://www.wpwhitesecurity.com/wordpress-plugins/password-policy-manager-wordpress/?utm_source=plugin&utm_medium=wsal&utm_campaign=xpromo',
	),
	array(
		'img'  => trailingslashit( WFCM_BASE_URL ) . 'assets/img/about/activity-log-for-mainwp.jpg',
		'desc' => __( 'See the child sites activity logs from the central MainWP dashboard', 'website-file-changes-monitor' ),
		'alt'  => 'Activity Log for MainWP',
		'link' => 'https://www.wpsecurityauditlog.com/activity-log-mainwp-extension/?utm_source=plugin&utm_medium=wsal&utm_campaign=xpromo',
	),
);

?>
<br>
<p class="wfcm-about-logo"><a href="https://www.wpwhitesecurity.com/" target="_blank"><img src="<?php echo esc_url( WFCM_BASE_URL . 'assets/img/wp-white-security-full.svg' ); ?>" alt="<?php esc_attr_e( 'WP White Security', 'website-file-changes-monitor' ); ?>"></a></p>
<p><?php /* Translators: 1. WP plugins hyperlink 2. Contact form hyperlink */ echo sprintf( esc_html__( 'The WP File Changes Monitor plugin is developed by WP White Security, developers of %1$s. If you would like to get in touch with us, please use our %2$s.', 'website-file-changes-monitor' ), '<a href="https://www.wpwhitesecurity.com/wordpress-plugins/" target="_blank">' . esc_html__( 'high-quality niche WordPress security and admin plugins', 'website-file-changes-monitor' ) . '</a>', '<a href="https://www.wpwhitesecurity.com/contact-wp-white-security/" target="_blank">' . esc_html__( 'contact form', 'website-file-changes-monitor' ) . '</a>' ); ?></p>
<div class="our-wordpress-plugins full">
	<h3><?php esc_html_e( 'Our WordPress Plugins', 'website-file-changes-monitor' ); ?></h3>
	<ul>
		<?php foreach ( $plugins_data as $data ) : ?>
			<li>
				<div class="plugin-box">
					<div class="plugin-img">
						<img src="<?php echo esc_url( $data['img'] ); ?>" alt="<?php echo esc_attr( $data['alt'] ); ?>">
					</div>
					<div class="plugin-desc">
						<p><?php echo esc_html( $data['desc'] ); ?></p>
						<div class="cta-btn">
							<a href="<?php echo esc_url( $data['link'] ); ?>" target="_blank"><?php esc_html_e( 'LEARN MORE', 'website-file-changes-monitor' ); ?></a>
						</div>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
