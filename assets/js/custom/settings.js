/**
 * Settings JS.
 */
jQuery( document ).ready( function() {

	const keepLog = jQuery( 'input[name="wpfcm-settings[keep-log]"]' );
	const frequencySelect = jQuery( 'select[name="wpfcm-settings[scan-frequency]"]' );
	const scanDay = jQuery( 'select[name="wpfcm-settings[scan-day]"]' ).parent();
	const scanDate = jQuery( 'select[name="wpfcm-settings[scan-date]"]' ).parent();
	const excludeAdd = jQuery( '.wpfcm-files-container .add' );
	const excludeRemove = jQuery( '.wpfcm-files-container .remove' );

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

	/**
	 * Add Exclude Item.
	 */
	jQuery( excludeAdd ).click( function( event ) {
		event.preventDefault();

		let pattern = '';
		const excludeType = jQuery( this ).data( 'exclude-type' );

		if ( 'dir' === excludeType ) {
			pattern = /^\s*[a-z-._\d,\s/]+\s*$/i;
		} else if ( 'file' === excludeType ) {
			pattern = /^\s*[a-z-._\d,\s]+\s*$/i;
		} else if ( 'extension' === excludeType ) {
			pattern = /^\s*[a-z-._\d,\s]+\s*$/i;
		}

		const excludeList = jQuery( `#wpfcm-exclude-${excludeType}-list` );
		const excludeNameInput = jQuery( this ).parent().find( '.name' );
		const excludeName = excludeNameInput.val();

		if ( excludeName.match( pattern ) ) {
			const excludeItem = jQuery( '<span></span>' );
			const excludeItemInput = jQuery( '<input>' );
			const excludeItemLabel = jQuery( '<label></label>' );

			excludeItemInput.prop( 'type', 'checkbox' );
			excludeItemInput.prop( 'checked', true );
			excludeItemInput.prop( 'name', `wpfcm-settings[scan-exclude-${excludeType}][]` );
			excludeItemInput.prop( 'id', excludeName );
			excludeItemInput.prop( 'value', excludeName );

			excludeItemLabel.prop( 'for', excludeName );
			excludeItemLabel.text( excludeName );

			excludeItem.append( excludeItemInput );
			excludeItem.append( excludeItemLabel );
			excludeList.append( excludeItem );
			excludeNameInput.removeAttr( 'value' );
		} else {
			if ( 'dir' === excludeType ) {
				alert( wpfcmData.dirInvalid );
			} else if ( 'file' === excludeType ) {
				alert( wpfcmData.fileInvalid );
			} else if ( 'extension' === excludeType ) {
				alert( wpfcmData.extensionInvalid );
			}
		}
	});

	/**
	 * Remove Exclude Item(s).
	 */
	jQuery( excludeRemove ).click( function( event ) {
		event.preventDefault();

		const excludeItems = jQuery( this ).parent().find( '.exclude-list input[type=checkbox]' );
		let removedValues = [];

		for ( let index = 0; index < excludeItems.length; index++ ) {
			if ( ! jQuery( excludeItems[ index ]).is( ':checked' ) ) {
				removedValues.push( jQuery( excludeItems[ index ]).val() );
			}
		}

		if ( removedValues ) {
			for ( let index = 0; index < removedValues.length; index++ ) {
				let excludeItem = jQuery( 'input[value="' + removedValues[ index ] + '"]' );
				if ( excludeItem ) {
					excludeItem.parent().remove();
				}
			}
		}
	});

	// Update settings state on change.
	keepLog.change( function() {
		toggleSettings( jQuery( this ).val() );
	});

	// Toggle settings state on page load.
	toggleSettings( keepLog.val() );

	/**
	 * Toggle Plugin Settings State.
	 *
	 * @param {string} settingValue - Keep log setting value.
	 */
	function toggleSettings( settingValue ) {
		const settingFields = jQuery( '.wpfcm-table fieldset' );

		if ( 'no' === settingValue ) {
			settingFields.attr( 'disabled', true );
		} else {
			settingFields.removeAttr( 'disabled' );
		}
	}
});
