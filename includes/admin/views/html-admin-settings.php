<?php
/**
 * Settings View.
 *
 * @package wpfcm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Scan Frequencies.
 */
$frequency_options = apply_filters(
	'wpfcm_file_changes_scan_frequency', array(
		'daily'   => __( 'Daily', 'wp-file-changes-monitor' ),
		'weekly'  => __( 'Weekly', 'wp-file-changes-monitor' ),
		'monthly' => __( 'Monthly', 'wp-file-changes-monitor' ),
	)
);

// Scan hours option.
$scan_hours = array(
	'00' => __( '00:00', 'wp-file-changes-monitor' ),
	'01' => __( '01:00', 'wp-file-changes-monitor' ),
	'02' => __( '02:00', 'wp-file-changes-monitor' ),
	'03' => __( '03:00', 'wp-file-changes-monitor' ),
	'04' => __( '04:00', 'wp-file-changes-monitor' ),
	'05' => __( '05:00', 'wp-file-changes-monitor' ),
	'06' => __( '06:00', 'wp-file-changes-monitor' ),
	'07' => __( '07:00', 'wp-file-changes-monitor' ),
	'08' => __( '08:00', 'wp-file-changes-monitor' ),
	'09' => __( '09:00', 'wp-file-changes-monitor' ),
	'10' => __( '10:00', 'wp-file-changes-monitor' ),
	'11' => __( '11:00', 'wp-file-changes-monitor' ),
	'12' => __( '12:00', 'wp-file-changes-monitor' ),
	'13' => __( '13:00', 'wp-file-changes-monitor' ),
	'14' => __( '14:00', 'wp-file-changes-monitor' ),
	'15' => __( '15:00', 'wp-file-changes-monitor' ),
	'16' => __( '16:00', 'wp-file-changes-monitor' ),
	'17' => __( '17:00', 'wp-file-changes-monitor' ),
	'18' => __( '18:00', 'wp-file-changes-monitor' ),
	'19' => __( '19:00', 'wp-file-changes-monitor' ),
	'20' => __( '20:00', 'wp-file-changes-monitor' ),
	'21' => __( '21:00', 'wp-file-changes-monitor' ),
	'22' => __( '22:00', 'wp-file-changes-monitor' ),
	'23' => __( '23:00', 'wp-file-changes-monitor' ),
);

// Scan days option.
$scan_days = array(
	'1' => __( 'Monday', 'wp-file-changes-monitor' ),
	'2' => __( 'Tuesday', 'wp-file-changes-monitor' ),
	'3' => __( 'Wednesday', 'wp-file-changes-monitor' ),
	'4' => __( 'Thursday', 'wp-file-changes-monitor' ),
	'5' => __( 'Friday', 'wp-file-changes-monitor' ),
	'6' => __( 'Saturday', 'wp-file-changes-monitor' ),
	'7' => __( 'Sunday', 'wp-file-changes-monitor' ),
);

// Scan date option.
$scan_date = array(
	'01' => __( '01', 'wp-file-changes-monitor' ),
	'02' => __( '02', 'wp-file-changes-monitor' ),
	'03' => __( '03', 'wp-file-changes-monitor' ),
	'04' => __( '04', 'wp-file-changes-monitor' ),
	'05' => __( '05', 'wp-file-changes-monitor' ),
	'06' => __( '06', 'wp-file-changes-monitor' ),
	'07' => __( '07', 'wp-file-changes-monitor' ),
	'08' => __( '08', 'wp-file-changes-monitor' ),
	'09' => __( '09', 'wp-file-changes-monitor' ),
	'10' => __( '10', 'wp-file-changes-monitor' ),
	'11' => __( '11', 'wp-file-changes-monitor' ),
	'12' => __( '12', 'wp-file-changes-monitor' ),
	'13' => __( '13', 'wp-file-changes-monitor' ),
	'14' => __( '14', 'wp-file-changes-monitor' ),
	'15' => __( '15', 'wp-file-changes-monitor' ),
	'16' => __( '16', 'wp-file-changes-monitor' ),
	'17' => __( '17', 'wp-file-changes-monitor' ),
	'18' => __( '18', 'wp-file-changes-monitor' ),
	'19' => __( '19', 'wp-file-changes-monitor' ),
	'20' => __( '20', 'wp-file-changes-monitor' ),
	'21' => __( '21', 'wp-file-changes-monitor' ),
	'22' => __( '22', 'wp-file-changes-monitor' ),
	'23' => __( '23', 'wp-file-changes-monitor' ),
	'24' => __( '24', 'wp-file-changes-monitor' ),
	'25' => __( '25', 'wp-file-changes-monitor' ),
	'26' => __( '26', 'wp-file-changes-monitor' ),
	'27' => __( '27', 'wp-file-changes-monitor' ),
	'28' => __( '28', 'wp-file-changes-monitor' ),
	'29' => __( '29', 'wp-file-changes-monitor' ),
	'30' => __( '30', 'wp-file-changes-monitor' ),
);

// WP Directories.
$wp_directories = array(
	'root'               => __( 'Root directory of WordPress (excluding sub directories)', 'wp-file-changes-monitor' ),
	'wp-admin'           => __( 'WP Admin directory (/wp-admin/)', 'wp-file-changes-monitor' ),
	'wp-includes'        => __( 'WP Includes directory (/wp-includes/)', 'wp-file-changes-monitor' ),
	'wp-content'         => __( '/wp-content/ directory (other than the plugins, themes & upload directories)', 'wp-file-changes-monitor' ),
	'wp-content/themes'  => __( 'Themes directory (/wp-content/themes/)', 'wp-file-changes-monitor' ),
	'wp-content/plugins' => __( 'Plugins directory (/wp-content/plugins/)', 'wp-file-changes-monitor' ),
	'wp-content/uploads' => __( 'Uploads directory (/wp-content/uploads/)', 'wp-file-changes-monitor' ),
);

if ( is_multisite() ) {
	// Upload directories of subsites.
	$wp_directories['wp-content/uploads/sites'] = __( 'Uploads directory of all sub sites on this network (/wp-content/sites/*)', 'wp-file-changes-monitor' );
}

$wp_directories = apply_filters( 'wpfcm_file_changes_scan_directories', $wp_directories );

?>

<div class="wrap wpfcm-settings">
	<h1><?php esc_html_e( 'File Changes Settings', 'wp-file-changes-monitor' ); ?></h1>
	<form method="post" action="" enctype="multipart/form-data">
		<h3><?php esc_html_e( 'Which file changes events do you want to keep a log of in the activity log?', 'wp-file-changes-monitor' ); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="wpfcm-file-changes-type"><?php esc_html_e( 'Notify me when', 'wp-file-changes-monitor' ); ?></label></th>
				<td>
					<fieldset>
						<label for="added">
							<input type="checkbox" name="wpfcm-settings[scan-type][]" value="added" <?php echo in_array( 'added', $settings['type'], true ) ? 'checked' : false; ?>>
							<span><?php esc_html_e( 'Files are added', 'wp-file-changes-monitor' ); ?></span>
						</label>
						<br>
						<label for="deleted">
							<input type="checkbox" name="wpfcm-settings[scan-type][]" value="deleted" <?php echo in_array( 'deleted', $settings['type'], true ) ? 'checked' : false; ?>>
							<span><?php esc_html_e( 'Files are deleted', 'wp-file-changes-monitor' ); ?></span>
						</label>
						<br>
						<label for="modified">
							<input type="checkbox" name="wpfcm-settings[scan-type][]" value="modified" <?php echo in_array( 'modified', $settings['type'], true ) ? 'checked' : false; ?>>
							<span><?php esc_html_e( 'Files are modified', 'wp-file-changes-monitor' ); ?></span>
						</label>
					</fieldset>
				</td>
			</tr>
		</table>
		<!-- Type of Changes -->

		<h3><?php esc_html_e( 'When should the plugin scan your website for file changes?', 'wp-file-changes-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'By default the plugin will run file changes scans once a week. If you can, ideally you should run file changes scans on a daily basis. The file changes scanner is very efficient and requires very little resources. Though if you have a fairly large website we recommend you to scan it when it is the least busy. The scan process should only take a few seconds to complete.', 'wp-file-changes-monitor' ); ?></p>
		<table class="form-table">
			<tr>
				<th><label for="wpfcm-settings-frequency"><?php esc_html_e( 'Scan Frequency', 'wp-file-changes-monitor' ); ?></label></th>
				<td>
					<fieldset>
						<select name="wpfcm-settings[scan-frequency]">
							<?php foreach ( $frequency_options as $value => $html ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $settings['frequency'] ); ?>><?php echo esc_html( $html ); ?></option>
							<?php endforeach; ?>
						</select>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th><label for="wpfcm-settings-scan-hour"><?php esc_html_e( 'Scan Time', 'wp-file-changes-monitor' ); ?></label></th>
				<td>
					<fieldset>
						<label>
							<select name="wpfcm-settings[scan-hour]">
								<?php foreach ( $scan_hours as $value => $html ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $settings['hour'] ); ?>><?php echo esc_html( $html ); ?></option>
								<?php endforeach; ?>
							</select>
							<br />
							<span class="description"><?php esc_html_e( 'Hour', 'wp-file-changes-monitor' ); ?></span>
						</label>

						<label>
							<select name="wpfcm-settings[scan-day]">
								<?php foreach ( $scan_days as $value => $html ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $settings['day'] ); ?>><?php echo esc_html( $html ); ?></option>
								<?php endforeach; ?>
							</select>
							<br />
							<span class="description"><?php esc_html_e( 'Day', 'wp-file-changes-monitor' ); ?></span>
						</label>

						<label>
							<select name="wpfcm-settings[scan-date]">
								<?php foreach ( $scan_date as $value => $html ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $settings['date'] ); ?>><?php echo esc_html( $html ); ?></option>
								<?php endforeach; ?>
							</select>
							<br />
							<span class="description"><?php esc_html_e( 'Day', 'wp-file-changes-monitor' ); ?></span>
						</label>
					</fieldset>
				</td>
			</tr>
		</table>
		<!-- Scan frequency -->

		<h3><?php esc_html_e( 'Which directories should be scanned for file changes?', 'wp-file-changes-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'The plugin will scan all the directories in your WordPress website by default because that is the most secure option. Though if for some reason you do not want the plugin to scan any of these directories you can uncheck them from the below list.', 'wp-file-changes-monitor' ); ?></p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="wpfcm-settings-directories"><?php esc_html_e( 'Directories to scan', 'wp-file-changes-monitor' ); ?></label></th>
					<td>
						<fieldset>
							<?php foreach ( $wp_directories as $value => $html ) : ?>
								<label>
									<input name="wpfcm-settings[scan-directories][]" type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php echo in_array( $value, $settings['directories'], true ) ? 'checked' : false; ?> />
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

		<h3><?php esc_html_e( 'What is the biggest file size the plugin should scan?', 'wp-file-changes-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'By default the plugin does not scan files that are bigger than 5MB. Such files are not common, hence typically not a target.', 'wp-file-changes-monitor' ); ?></p>
		<table class="form-table">
			<tr>
				<th><label for="wpfcm-settings-file-size"><?php esc_html_e( 'File Size Limit', 'wp-file-changes-monitor' ); ?></label></th>
				<td>
					<fieldset>
						<input type="number" name="wpfcm-settings[scan-file-size]" min="1" max="100" value="<?php echo esc_attr( $settings['file-size'] ); ?>" /> <?php esc_html_e( 'MB', 'wp-file-changes-monitor' ); ?>
					</fieldset>
				</td>
			</tr>
		</table>
		<!-- Maximum File Size -->

		<h3><?php esc_html_e( 'Do you want to exclude specific files or files with a particular extension from the scan?', 'wp-file-changes-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'The plugin will scan everything that is in the WordPress root directory or below, even if the files and directories are not part of WordPress. It is recommended to scan all source code files and only exclude files that cannot be tampered, such as text files, media files etc, most of which are already excluded by default.', 'wp-file-changes-monitor' ); ?></p>
		<table class="form-table">
			<tr>
				<th><label for="wpfcm-settings-exclude-dirs"><?php esc_html_e( 'Exclude All Files in These Directories', 'wp-file-changes-monitor' ); ?></label></th>
				<td>
					<div class="wpfcm-files-container">
						<div class="exclude-list" id="wpfcm-exclude-dir-list">
							<?php foreach ( $settings['exclude-dirs'] as $dir ) : ?>
								<span>
									<input type="checkbox" name="wpfcm-settings[scan-exclude-dir][]" id="<?php echo esc_attr( $dir ); ?>" value="<?php echo esc_attr( $dir ); ?>" checked />
									<label for="<?php echo esc_attr( $dir ); ?>"><?php echo esc_html( $dir ); ?></label>
								</span>
							<?php endforeach; ?>
						</div>
						<input class="button remove" data-exclude-type="dir" type="button" value="<?php esc_html_e( 'REMOVE', 'wp-file-changes-monitor' ); ?>" />
					</div>
					<div class="wpfcm-files-container">
						<input class="name" type="text">
						<input class="button add" data-exclude-type="dir" type="button" value="<?php esc_html_e( 'ADD', 'wp-file-changes-monitor' ); ?>" />
					</div>
					<p class="description">
						<?php esc_html_e( 'Specify the name of the directory and the path to it in relation to the website\'s root. For example, if you want to want to exclude all files in the sub directory dir1/dir2 specify the following:', 'wp-file-changes-monitor' ); ?>
						<br>
						<?php echo esc_html( trailingslashit( ABSPATH ) ) . 'dir1/dir2/'; ?>
					</p>
					<span class="error hide" id="wpfcm-exclude-dir-error"></span>
				</td>
			</tr>
			<!-- Exclude directories -->
			<tr>
				<th><label for="wpfcm-settings-exclude-filenames"><?php esc_html_e( 'Exclude These Files', 'wp-file-changes-monitor' ); ?></label></th>
				<td>
					<div class="wpfcm-files-container">
						<div class="exclude-list" id="wpfcm-exclude-file-list">
							<?php foreach ( $settings['exclude-files'] as $file ) : ?>
								<span>
									<input type="checkbox" name="wpfcm-settings[scan-exclude-file][]" id="<?php echo esc_attr( $file ); ?>" value="<?php echo esc_attr( $file ); ?>" checked />
									<label for="<?php echo esc_attr( $file ); ?>"><?php echo esc_html( $file ); ?></label>
								</span>
							<?php endforeach; ?>
						</div>
						<input class="button remove" data-exclude-type="file" type="button" value="<?php esc_html_e( 'REMOVE', 'wp-file-changes-monitor' ); ?>" />
					</div>
					<div class="wpfcm-files-container">
						<input class="name" type="text">
						<input class="button add" data-exclude-type="file" type="button" value="<?php esc_html_e( 'ADD', 'wp-file-changes-monitor' ); ?>" />
					</div>
					<p class="description"><?php esc_html_e( 'Specify the name and extension of the file(s) you want to exclude. Wildcard not supported. There is no need to specify the path of the file.', 'wp-file-changes-monitor' ); ?></p>
					<span class="error hide" id="wpfcm-exclude-file-error"></span>
				</td>
			</tr>
			<!-- Exclude filenames -->
			<tr>
				<th><label for="wpfcm-settings-exclude-extensions"><?php esc_html_e( 'Exclude these File Types', 'wp-file-changes-monitor' ); ?></label></th>
				<td>
					<div class="wpfcm-files-container">
						<div class="exclude-list" id="wpfcm-exclude-extension-list">
							<?php foreach ( $settings['exclude-exts'] as $file_type ) : ?>
								<span>
									<input type="checkbox" name="wpfcm-settings[scan-exclude-extension][]" id="<?php echo esc_attr( $file_type ); ?>" value="<?php echo esc_attr( $file_type ); ?>" checked />
									<label for="<?php echo esc_attr( $file_type ); ?>"><?php echo esc_html( $file_type ); ?></label>
								</span>
							<?php endforeach; ?>
						</div>
						<input class="button remove" data-exclude-type="extension" type="button" value="<?php esc_html_e( 'REMOVE', 'wp-file-changes-monitor' ); ?>" />
					</div>
					<div class="wpfcm-files-container">
						<input class="name" type="text">
						<input class="button add" data-exclude-type="extension" type="button" value="<?php esc_html_e( 'ADD', 'wp-file-changes-monitor' ); ?>" />
					</div>
					<p class="description"><?php esc_html_e( 'Specify the extension of the file types you want to exclude. You should exclude any type of logs and backup files that tend to be very big.', 'wp-file-changes-monitor' ); ?></p>
					<span class="error hide" id="wpfcm-exclude-extension-error"></span>
				</td>
			</tr>
			<!-- Exclude extensions -->
		</table>
		<!-- Exclude directories, files, extensions -->

		<h3><?php esc_html_e( 'Launch an instant file changes scan', 'wp-file-changes-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'Click the Scan Now button to launch an instant file changes scan using the configured settings. You can navigate away from this page during the scan. Note that the instant scan can be more resource intensive than scheduled scans.', 'wp-file-changes-monitor' ); ?></p>
		<table class="form-table wsal-tab">
			<tbody>
				<tr>
					<th>
						<label for="wsal-scan-now"><?php esc_html_e( 'Launch Instant Scan', 'wp-file-changes-monitor' ); ?></label>
					</th>
					<td>
						<input type="button" class="button-primary" id="wsal-scan-now" value="<?php esc_attr_e( 'Scan Now', 'wp-file-changes-monitor' ); ?>">
						<input type="button" class="button-secondary" id="wsal-stop-scan" value="<?php esc_attr_e( 'Stop Scan', 'wp-file-changes-monitor' ); ?>" disabled>
						<?php // if ( 'enable' === $this->scan_settings['scan_file_changes'] && ! $this->scan_settings['scan_in_progress'] ) : ?>
						<?php // elseif ( 'enable' === $this->scan_settings['scan_file_changes'] && $this->scan_settings['scan_in_progress'] ) : ?>
							<!-- <input type="button" class="button button-primary" id="wsal-scan-now" value="<?php // esc_attr_e( 'Scan in Progress', 'wp-file-changes-monitor' ); ?>" disabled>
							<input type="button" class="button button-ui-primary" id="wsal-stop-scan" value="<?php // esc_attr_e( 'Stop Scan', 'wp-file-changes-monitor' ); ?>"> -->
							<!-- Scan in progress -->
						<?php // else : ?>
							<!-- <input type="button" class="button button-primary" id="wsal-scan-now" value="<?php // esc_attr_e( 'Scan Now', 'wp-file-changes-monitor' ); ?>" disabled>
							<input type="button" class="button button-secondary" id="wsal-stop-scan" value="<?php // esc_attr_e( 'Stop Scan', 'wp-file-changes-monitor' ); ?>" disabled> -->
						<?php // endif; ?>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- / Instant Scan -->

		<h3><?php esc_html_e( 'Enable File Scanning', 'wp-file-changes-monitor' ); ?></h3>
		<p class="description"><?php esc_html_e( 'Use this switch to temporarily disable file scanning. When you disable and re-enable file scanning the plugin will report all the file changes it identifies when it compares the files between the last scan before it was scanning was disabled and the first scan when it was enabled.', 'wp-file-changes-monitor' ); ?></p>
		<table class="form-table">
			<tr>
				<th><label for="wpfcm-file-changes"><?php esc_html_e( 'Keep a Log of File Changes', 'wp-file-changes-monitor' ); ?></label></th>
				<td>
					<fieldset>
						<label>
							<input name="wpfcm-settings[keep-log]" type="radio" value="yes" <?php checked( $settings['enabled'], 'yes' ); ?>>
							<?php esc_html_e( 'Yes', 'wp-file-changes-monitor' ); ?>
						</label>
						<br>
						<label>
							<input name="wpfcm-settings[keep-log]" type="radio" value="no" <?php checked( $settings['enabled'], 'no' ); ?>>
							<?php esc_html_e( 'No', 'wp-file-changes-monitor' ); ?>
						</label>
					</fieldset>
				</td>
			</tr>
		</table>
		<!-- Disable File Changes -->

		<?php
		wp_nonce_field( 'wpfcm-save-admin-settings' );
		submit_button();
		?>
	</form>
</div>
