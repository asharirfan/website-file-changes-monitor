/**
 * Settings JS.
 */
jQuery( document ).ready( function() {

	const frequencySelect = jQuery( 'select[name="wpfcm-settings[scan-frequency]"]' );
	const scanDay = jQuery( 'select[name="wpfcm-settings[scan-day]"]' ).parent();
	const scanDate = jQuery( 'select[name="wpfcm-settings[scan-date]"]' ).parent();
	const excludeName = jQuery( '.wpfcm-files-container .name' );
	const excludeAdd = jQuery( '.wpfcm-files-container .add' );
	const excludeRemove = jQuery( '.wpfcm-files-container .remove' );
	const excludeList = jQuery( '.wpfcm-files-container .exclude-list' );

	// Frequency handler.
	jQuery( frequencySelect ).change( function() {
		showScanFields( jQuery( this ).val() );
	});

	// Manage appearance on load.
	showScanFields( frequencySelect.val() );

	/**
	 * Show Scan Time fields according to selected frequency.
	 *
	 * @param {string} frequency - Scan frequency.
	 */
	function showScanFields( frequency ) {
		scanDay.addClass( 'hidden' );
		scanDate.addClass( 'hidden' );

		if ( 'weekly' === frequency ) {
			scanDay.removeClass( 'hidden' );
		} else if ( 'monthly' === frequency ) {
			scanDate.removeClass( 'hidden' );
		}
	}
});
