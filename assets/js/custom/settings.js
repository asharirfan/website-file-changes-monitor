/**
 * Settings JS.
 */
window.addEventListener( 'load', function() {

	const $ = document.querySelector.bind( document );
	const keepLog = document.querySelectorAll( 'input[name="wpfcm-settings[keep-log]"]' );
	const frequencySelect = $( 'select[name="wpfcm-settings[scan-frequency]"]' );
	const scanDay = $( 'select[name="wpfcm-settings[scan-day]"]' ).parentNode;
	const scanDate = $( 'select[name="wpfcm-settings[scan-date]"]' ).parentNode;
	const excludeAdd = document.querySelectorAll( '.wpfcm-files-container .add' );
	const excludeRemove = document.querySelectorAll( '.wpfcm-files-container .remove' );

	// Frequency handler.
	frequencySelect.addEventListener( 'change', function() {
		showScanFields( this.value );
	});

	// Manage appearance on load.
	showScanFields( frequencySelect.value );

	/**
	 * Show Scan Time fields according to selected frequency.
	 *
	 * @param {string} frequency - Scan frequency.
	 */
	function showScanFields( frequency ) {
		scanDay.classList.add( 'hidden' );
		scanDate.classList.add( 'hidden' );

		if ( 'weekly' === frequency ) {
			scanDay.classList.remove( 'hidden' );
		} else if ( 'monthly' === frequency ) {
			scanDate.classList.remove( 'hidden' );
		}
	}

	// Add Exclude Item.
	[ ...excludeAdd ].forEach( excludeAddButton => {
		excludeAddButton.addEventListener( 'click', addToExcludeList );
	});

	// Remove Exclude Item(s).
	[ ...excludeRemove ].forEach( excludeRemoveButton => {
		excludeRemoveButton.addEventListener( 'click', removeFromExcludeList );
	});

	/**
	 * Add item to exclude list.
	 *
	 * @param {Event} e Event object.
	 */
	function addToExcludeList( e ) {
		let pattern = '';
		const excludeType = e.target.dataset.excludeType;

		if ( 'dirs' === excludeType ) {
			pattern = /^\s*[a-z-._\d,\s/]+\s*$/i;
		} else if ( 'files' === excludeType ) {
			pattern = /^\s*[a-z-._\d,\s]+\s*$/i;
		} else if ( 'exts' === excludeType ) {
			pattern = /^\s*[a-z-._\d,\s]+\s*$/i;
		}

		const excludeList = $( `#wpfcm-exclude-${excludeType}-list` );
		const excludeNameInput = e.target.parentNode.querySelector( '.name' );
		const excludeName = excludeNameInput.value;

		if ( excludeName.match( pattern ) ) {
			const excludeItem = document.createElement( 'span' );
			const excludeItemInput = document.createElement( 'input' );
			const excludeItemLabel = document.createElement( 'label' );

			excludeItemInput.type = 'checkbox';
			excludeItemInput.checked = true;
			excludeItemInput.name = `wpfcm-settings[scan-exclude-${excludeType}][]`;
			excludeItemInput.id = excludeName;
			excludeItemInput.value = excludeName;

			excludeItemLabel.setAttribute( 'for', excludeName );
			excludeItemLabel.innerHTML = excludeName;

			excludeItem.appendChild( excludeItemInput );
			excludeItem.appendChild( excludeItemLabel );
			excludeList.appendChild( excludeItem );
			excludeNameInput.value = '';
		} else {
			if ( 'dirs' === excludeType ) {
				alert( wpfcmData.dirInvalid );
			} else if ( 'files' === excludeType ) {
				alert( wpfcmData.fileInvalid );
			} else if ( 'exts' === excludeType ) {
				alert( wpfcmData.extensionInvalid );
			}
		}
	}

	/**
	 * Remove item from exclude list.
	 *
	 * @param {Event} e Event object.
	 */
	function removeFromExcludeList( e ) {
		const excludeItems = [ ...e.target.parentNode.querySelectorAll( '.exclude-list input[type=checkbox]' ) ];
		let removedValues = [];

		for ( let index = 0; index < excludeItems.length; index++ ) {
			if ( ! excludeItems[ index ].checked ) {
				removedValues.push( excludeItems[ index ].value );
			}
		}

		if ( removedValues.length ) {
			for ( let index = 0; index < removedValues.length; index++ ) {
				let excludeItem = $( 'input[value="' + removedValues[ index ] + '"]' );
				if ( excludeItem ) {
					excludeItem.parentNode.remove();
				}
			}
		}
	}

	// Update settings state when keep log options change.
	[ ...keepLog ].forEach( toggle => {
		toggle.addEventListener( 'change', function() {
			toggleSettings( this.value );
		});
	});

	/**
	 * Toggle Plugin Settings State.
	 *
	 * @param {string} settingValue - Keep log setting value.
	 */
	function toggleSettings( settingValue ) {
		const settingFields = [ ...document.querySelectorAll( '.wpfcm-table fieldset' ) ];

		settingFields.forEach( setting => {
			if ( 'no' === settingValue ) {
				setting.disabled = true;
			} else {
				setting.disabled = false;
			}
		});
	}
});
