<?php
/**
 * Settings View.
 *
 * @package wfm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Scan Frequencies.
 */
$frequency_options = apply_filters(
	'wfm_file_changes_scan_frequency',
	array(
		'daily'   => __( 'Daily', 'website-files-monitor' ),
		'weekly'  => __( 'Weekly', 'website-files-monitor' ),
		'monthly' => __( 'Monthly', 'website-files-monitor' ),
	)
);

// Scan hours option.
$scan_hours = array(
	'00' => __( '00:00', 'website-files-monitor' ),
	'01' => __( '01:00', 'website-files-monitor' ),
	'02' => __( '02:00', 'website-files-monitor' ),
	'03' => __( '03:00', 'website-files-monitor' ),
	'04' => __( '04:00', 'website-files-monitor' ),
	'05' => __( '05:00', 'website-files-monitor' ),
	'06' => __( '06:00', 'website-files-monitor' ),
	'07' => __( '07:00', 'website-files-monitor' ),
	'08' => __( '08:00', 'website-files-monitor' ),
	'09' => __( '09:00', 'website-files-monitor' ),
	'10' => __( '10:00', 'website-files-monitor' ),
	'11' => __( '11:00', 'website-files-monitor' ),
	'12' => __( '12:00', 'website-files-monitor' ),
	'13' => __( '13:00', 'website-files-monitor' ),
	'14' => __( '14:00', 'website-files-monitor' ),
	'15' => __( '15:00', 'website-files-monitor' ),
	'16' => __( '16:00', 'website-files-monitor' ),
	'17' => __( '17:00', 'website-files-monitor' ),
	'18' => __( '18:00', 'website-files-monitor' ),
	'19' => __( '19:00', 'website-files-monitor' ),
	'20' => __( '20:00', 'website-files-monitor' ),
	'21' => __( '21:00', 'website-files-monitor' ),
	'22' => __( '22:00', 'website-files-monitor' ),
	'23' => __( '23:00', 'website-files-monitor' ),
);

// Scan days option.
$scan_days = array(
	'1' => __( 'Monday', 'website-files-monitor' ),
	'2' => __( 'Tuesday', 'website-files-monitor' ),
	'3' => __( 'Wednesday', 'website-files-monitor' ),
	'4' => __( 'Thursday', 'website-files-monitor' ),
	'5' => __( 'Friday', 'website-files-monitor' ),
	'6' => __( 'Saturday', 'website-files-monitor' ),
	'7' => __( 'Sunday', 'website-files-monitor' ),
);

// Scan date option.
$scan_date = array(
	'01' => __( '01', 'website-files-monitor' ),
	'02' => __( '02', 'website-files-monitor' ),
	'03' => __( '03', 'website-files-monitor' ),
	'04' => __( '04', 'website-files-monitor' ),
	'05' => __( '05', 'website-files-monitor' ),
	'06' => __( '06', 'website-files-monitor' ),
	'07' => __( '07', 'website-files-monitor' ),
	'08' => __( '08', 'website-files-monitor' ),
	'09' => __( '09', 'website-files-monitor' ),
	'10' => __( '10', 'website-files-monitor' ),
	'11' => __( '11', 'website-files-monitor' ),
	'12' => __( '12', 'website-files-monitor' ),
	'13' => __( '13', 'website-files-monitor' ),
	'14' => __( '14', 'website-files-monitor' ),
	'15' => __( '15', 'website-files-monitor' ),
	'16' => __( '16', 'website-files-monitor' ),
	'17' => __( '17', 'website-files-monitor' ),
	'18' => __( '18', 'website-files-monitor' ),
	'19' => __( '19', 'website-files-monitor' ),
	'20' => __( '20', 'website-files-monitor' ),
	'21' => __( '21', 'website-files-monitor' ),
	'22' => __( '22', 'website-files-monitor' ),
	'23' => __( '23', 'website-files-monitor' ),
	'24' => __( '24', 'website-files-monitor' ),
	'25' => __( '25', 'website-files-monitor' ),
	'26' => __( '26', 'website-files-monitor' ),
	'27' => __( '27', 'website-files-monitor' ),
	'28' => __( '28', 'website-files-monitor' ),
	'29' => __( '29', 'website-files-monitor' ),
	'30' => __( '30', 'website-files-monitor' ),
);

// WP Directories.
$wp_directories = array(
	'root'               => __( 'Root directory of WordPress (excluding sub directories)', 'website-files-monitor' ),
	'wp-admin'           => __( 'WP Admin directory (/wp-admin/)', 'website-files-monitor' ),
	'wp-includes'        => __( 'WP Includes directory (/wp-includes/)', 'website-files-monitor' ),
	'wp-content'         => __( '/wp-content/ directory (other than the plugins, themes & upload directories)', 'website-files-monitor' ),
	'wp-content/themes'  => __( 'Themes directory (/wp-content/themes/)', 'website-files-monitor' ),
	'wp-content/plugins' => __( 'Plugins directory (/wp-content/plugins/)', 'website-files-monitor' ),
	'wp-content/uploads' => __( 'Uploads directory (/wp-content/uploads/)', 'website-files-monitor' ),
);

if ( is_multisite() ) {
	// Upload directories of subsites.
	$wp_directories['wp-content/uploads/sites'] = __( 'Uploads directory of all sub sites on this network (/wp-content/sites/*)', 'website-files-monitor' );
}

$wp_directories = apply_filters( 'wfm_file_changes_scan_directories', $wp_directories );

$disabled = 'no' === $settings['enabled'] ? 'disabled' : false;
?>

<div class="wrap wfm-settings">
	<h1><?php esc_html_e( 'File Changes Settings', 'website-files-monitor' ); ?></h1>
	<?php self::show_messages(); ?>
	<form method="post" action="" enctype="multipart/form-data">
		<h3><?php esc_html_e( 'Which file changes events do you want to keep a log of in the activity log?', 'website-files-monitor' ); ?></h3>
		<table class="form-table wfm-table">
			<tr>
				<th><label for="wfm-file-changes-type"><?php esc_html_e( 'Notify me when', 'website-files-monitor' ); ?></label></th>
				<td>
					<fieldset <?php echo esc_attr( $disabled ); ?>>
						<label for="added">
							<input type="checkbox" name="wfm-settings[scan-type][]" value="added" <?php echo in_array( 'added', $settings['type'], true ) ? 'checked' : false; ?>>
							<span><?php esc_html_e( 'Files are added', 'website-files-monitor' ); ?></span>
						</label>
						<br>
						<label for="deleted">
							<input type="checkbox" name="wfm-settings[scan-type][]" value="deleted" <?php echo in_array( 'deleted', $settings['type'], true ) ? 'checked' : false; ?>>
							<span><?php esc_html_e( 'Files are deleted', 'website-files-monitor' ); ?></span>
						</label>
						<br>
						<label for="modified">
							<input type="checkbox" name="wfm-settings[scan-type][]" value="modified" <?php echo in_array( 'modified', $settings['type'], true ) ? 'checked' : false; ?>>
							<span><?php esc_html_e( 'Files are modified', 'website-files-monitor' ); ?></span>
						</label>
					</fieldset>
				</td>
			</tr>
		</table>
		<!-- Type of Changes -->

		<h3><?php esc_html_e( 'When should the plugin scan your website for file changes?', 'website-files-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'By default the plugin will run file changes scans once a week. If you can, ideally you should run file changes scans on a daily basis. The file changes scanner is very efficient and requires very little resources. Though if you have a fairly large website we recommend you to scan it when it is the least busy. The scan process should only take a few seconds to complete.', 'website-files-monitor' ); ?></p>
		<table class="form-table wfm-table">
			<tr>
				<th><label for="wfm-settings-frequency"><?php esc_html_e( 'Scan Frequency', 'website-files-monitor' ); ?></label></th>
				<td>
					<fieldset <?php echo esc_attr( $disabled ); ?>>
						<select name="wfm-settings[scan-frequency]">
							<?php foreach ( $frequency_options as $value => $html ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $settings['frequency'] ); ?>><?php echo esc_html( $html ); ?></option>
							<?php endforeach; ?>
						</select>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th><label for="wfm-settings-scan-hour"><?php esc_html_e( 'Scan Time', 'website-files-monitor' ); ?></label></th>
				<td>
					<fieldset <?php echo esc_attr( $disabled ); ?>>
						<label>
							<select name="wfm-settings[scan-hour]">
								<?php foreach ( $scan_hours as $value => $html ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $settings['hour'] ); ?>><?php echo esc_html( $html ); ?></option>
								<?php endforeach; ?>
							</select>
							<br />
							<span class="description"><?php esc_html_e( 'Hour', 'website-files-monitor' ); ?></span>
						</label>

						<label>
							<select name="wfm-settings[scan-day]">
								<?php foreach ( $scan_days as $value => $html ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $settings['day'] ); ?>><?php echo esc_html( $html ); ?></option>
								<?php endforeach; ?>
							</select>
							<br />
							<span class="description"><?php esc_html_e( 'Day', 'website-files-monitor' ); ?></span>
						</label>

						<label>
							<select name="wfm-settings[scan-date]">
								<?php foreach ( $scan_date as $value => $html ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $settings['date'] ); ?>><?php echo esc_html( $html ); ?></option>
								<?php endforeach; ?>
							</select>
							<br />
							<span class="description"><?php esc_html_e( 'Day', 'website-files-monitor' ); ?></span>
						</label>
					</fieldset>
				</td>
			</tr>
		</table>
		<!-- Scan frequency -->

		<h3><?php esc_html_e( 'Which directories should be scanned for file changes?', 'website-files-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'The plugin will scan all the directories in your WordPress website by default because that is the most secure option. Though if for some reason you do not want the plugin to scan any of these directories you can uncheck them from the below list.', 'website-files-monitor' ); ?></p>
		<table class="form-table wfm-table">
			<tbody>
				<tr>
					<th><label for="wfm-settings-directories"><?php esc_html_e( 'Directories to scan', 'website-files-monitor' ); ?></label></th>
					<td>
						<fieldset <?php echo esc_attr( $disabled ); ?>>
							<?php foreach ( $wp_directories as $value => $html ) : ?>
								<label>
									<input name="wfm-settings[scan-directories][]" type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php echo in_array( $value, $settings['directories'], true ) ? 'checked' : false; ?> />
									<?php echo esc_html( $html ); ?>
								</label>
								<br />
							<?php endforeach; ?>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Scan directories -->

		<h3><?php esc_html_e( 'What is the biggest file size the plugin should scan?', 'website-files-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'By default the plugin does not scan files that are bigger than 5MB. Such files are not common, hence typically not a target.', 'website-files-monitor' ); ?></p>
		<table class="form-table wfm-table">
			<tr>
				<th><label for="wfm-settings-file-size"><?php esc_html_e( 'File Size Limit', 'website-files-monitor' ); ?></label></th>
				<td>
					<fieldset <?php echo esc_attr( $disabled ); ?>>
						<input type="number" name="wfm-settings[scan-file-size]" min="1" max="100" value="<?php echo esc_attr( $settings['file-size'] ); ?>" /> <?php esc_html_e( 'MB', 'website-files-monitor' ); ?>
					</fieldset>
				</td>
			</tr>
		</table>
		<!-- Maximum File Size -->

		<h3><?php esc_html_e( 'Do you want to exclude specific files or files with a particular extension from the scan?', 'website-files-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'The plugin will scan everything that is in the WordPress root directory or below, even if the files and directories are not part of WordPress. It is recommended to scan all source code files and only exclude files that cannot be tampered, such as text files, media files etc, most of which are already excluded by default.', 'website-files-monitor' ); ?></p>
		<table class="form-table wfm-table">
			<tr>
				<th><label for="wfm-settings-exclude-dirs"><?php esc_html_e( 'Exclude All Files in These Directories', 'website-files-monitor' ); ?></label></th>
				<td>
					<fieldset <?php echo esc_attr( $disabled ); ?>>
						<div class="wfm-files-container">
							<div class="exclude-list" id="wfm-exclude-dirs-list">
								<?php foreach ( $settings['exclude-dirs'] as $dir ) : ?>
									<span>
										<input type="checkbox" name="wfm-settings[scan-exclude-dirs][]" id="<?php echo esc_attr( $dir ); ?>" value="<?php echo esc_attr( $dir ); ?>" checked />
										<label for="<?php echo esc_attr( $dir ); ?>"><?php echo esc_html( $dir ); ?></label>
									</span>
								<?php endforeach; ?>
							</div>
							<input class="button remove" data-exclude-type="dirs" type="button" value="<?php esc_html_e( 'REMOVE', 'website-files-monitor' ); ?>" />
						</div>
						<div class="wfm-files-container">
							<input class="name" type="text">
							<input class="button add" data-exclude-type="dirs" type="button" value="<?php esc_html_e( 'ADD', 'website-files-monitor' ); ?>" />
						</div>
						<p class="description">
							<?php esc_html_e( 'Specify the name of the directory and the path to it in relation to the website\'s root. For example, if you want to want to exclude all files in the sub directory dir1/dir2 specify the following:', 'website-files-monitor' ); ?>
							<br>
							<?php echo esc_html( trailingslashit( ABSPATH ) ) . 'dir1/dir2/'; ?>
						</p>
					</fieldset>
				</td>
			</tr>
			<!-- Exclude directories -->
			<tr>
				<th><label for="wfm-settings-exclude-filenames"><?php esc_html_e( 'Exclude These Files', 'website-files-monitor' ); ?></label></th>
				<td>
					<fieldset <?php echo esc_attr( $disabled ); ?>>
						<div class="wfm-files-container">
							<div class="exclude-list" id="wfm-exclude-files-list">
								<?php foreach ( $settings['exclude-files'] as $file ) : ?>
									<span>
										<input type="checkbox" name="wfm-settings[scan-exclude-files][]" id="<?php echo esc_attr( $file ); ?>" value="<?php echo esc_attr( $file ); ?>" checked />
										<label for="<?php echo esc_attr( $file ); ?>"><?php echo esc_html( $file ); ?></label>
									</span>
								<?php endforeach; ?>
							</div>
							<input class="button remove" data-exclude-type="files" type="button" value="<?php esc_html_e( 'REMOVE', 'website-files-monitor' ); ?>" />
						</div>
						<div class="wfm-files-container">
							<input class="name" type="text">
							<input class="button add" data-exclude-type="files" type="button" value="<?php esc_html_e( 'ADD', 'website-files-monitor' ); ?>" />
						</div>
						<p class="description"><?php esc_html_e( 'Specify the name and extension of the file(s) you want to exclude. Wildcard not supported. There is no need to specify the path of the file.', 'website-files-monitor' ); ?></p>
					</fieldset>
				</td>
			</tr>
			<!-- Exclude filenames -->
			<tr>
				<th><label for="wfm-settings-exclude-extensions"><?php esc_html_e( 'Exclude these File Types', 'website-files-monitor' ); ?></label></th>
				<td>
					<fieldset <?php echo esc_attr( $disabled ); ?>>
						<div class="wfm-files-container">
							<div class="exclude-list" id="wfm-exclude-exts-list">
								<?php foreach ( $settings['exclude-exts'] as $file_type ) : ?>
									<span>
										<input type="checkbox" name="wfm-settings[scan-exclude-exts][]" id="<?php echo esc_attr( $file_type ); ?>" value="<?php echo esc_attr( $file_type ); ?>" checked />
										<label for="<?php echo esc_attr( $file_type ); ?>"><?php echo esc_html( $file_type ); ?></label>
									</span>
								<?php endforeach; ?>
							</div>
							<input class="button remove" data-exclude-type="exts" type="button" value="<?php esc_html_e( 'REMOVE', 'website-files-monitor' ); ?>" />
						</div>
						<div class="wfm-files-container">
							<input class="name" type="text">
							<input class="button add" data-exclude-type="exts" type="button" value="<?php esc_html_e( 'ADD', 'website-files-monitor' ); ?>" />
						</div>
						<p class="description"><?php esc_html_e( 'Specify the extension of the file types you want to exclude. You should exclude any type of logs and backup files that tend to be very big.', 'website-files-monitor' ); ?></p>
					</fieldset>
				</td>
			</tr>
			<!-- Exclude extensions -->
		</table>
		<!-- Exclude directories, files, extensions -->

		<h3><?php esc_html_e( 'Launch an instant file changes scan', 'website-files-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'Click the Scan Now button to launch an instant file changes scan using the configured settings. You can navigate away from this page during the scan. Note that the instant scan can be more resource intensive than scheduled scans.', 'website-files-monitor' ); ?></p>
		<table class="form-table wfm-table">
			<tbody>
				<tr>
					<th>
						<label><?php esc_html_e( 'Launch Instant Scan', 'website-files-monitor' ); ?></label>
					</th>
					<td>
						<fieldset <?php echo esc_attr( $disabled ); ?>>
							<?php if ( 'yes' === $settings['enabled'] && ! wfm_get_setting( 'scan-in-progress', false ) ) : ?>
								<input type="button" class="button-primary" id="wfm-scan-start" value="<?php esc_attr_e( 'Scan Now', 'website-files-monitor' ); ?>">
								<input type="button" class="button-secondary" id="wfm-scan-stop" value="<?php esc_attr_e( 'Stop Scan', 'website-files-monitor' ); ?>" disabled>
							<?php elseif ( 'no' === $settings['enabled'] && wfm_get_setting( 'scan-in-progress', false ) ) : ?>
								<input type="button" class="button button-primary" id="wfm-scan-start" value="<?php esc_attr_e( 'Scan in Progress', 'website-files-monitor' ); ?>" disabled>
								<input type="button" class="button button-ui-primary" id="wfm-scan-stop" value="<?php esc_attr_e( 'Stop Scan', 'website-files-monitor' ); ?>">
								<!-- Scan in progress -->
							<?php else : ?>
								<input type="button" class="button button-primary" id="wfm-scan-start" value="<?php esc_attr_e( 'Scan Now', 'website-files-monitor' ); ?>" disabled>
								<input type="button" class="button button-secondary" id="wfm-scan-stop" value="<?php esc_attr_e( 'Stop Scan', 'website-files-monitor' ); ?>" disabled>
							<?php endif; ?>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- / Instant Scan -->

		<h3><?php esc_html_e( 'Enable File Scanning', 'website-files-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'Use this switch to temporarily disable file scanning. When you disable and re-enable file scanning the plugin will report all the file changes it identifies when it compares the files between the last scan before it was scanning was disabled and the first scan when it was enabled.', 'website-files-monitor' ); ?></p>
		<table class="form-table">
			<tr>
				<th><label for="wfm-file-changes"><?php esc_html_e( 'Keep a Log of File Changes', 'website-files-monitor' ); ?></label></th>
				<td>
					<fieldset>
						<label><input name="wfm-settings[keep-log]" type="radio" value="yes" <?php checked( $settings['enabled'], 'yes' ); ?>><?php esc_html_e( 'Yes', 'website-files-monitor' ); ?></label>
						<br>
						<label><input name="wfm-settings[keep-log]" type="radio" value="no" <?php checked( $settings['enabled'], 'no' ); ?>><?php esc_html_e( 'No', 'website-files-monitor' ); ?></label>
					</fieldset>
				</td>
			</tr>
		</table>
		<!-- Disable File Changes -->

		<?php
		wp_nonce_field( 'wfm-save-admin-settings' );
		submit_button();
		?>
	</form>
</div>
