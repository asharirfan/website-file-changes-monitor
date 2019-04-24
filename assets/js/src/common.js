/**
 * Common JS
 */
window.addEventListener( 'load', function() {

	const dismissBtns = document.querySelectorAll( '.wfcm-admin-notice .button' );

	// Add Exclude Item.
	[ ...dismissBtns ].forEach( dismissBtn => {
		dismissBtn.addEventListener( 'click', wfcmDismissAdminNotice );
	});
});

/**
 * Send dismiss request to remove admin notice.
 *
 * @param {Event} e Event object.
 */
function wfcmDismissAdminNotice( e ) {

	const noticeId = e.target.dataset.noticeId;

	// Rest request object.
	const request = new Request( `${wfcmData.restAdminEndpoint}/${noticeId}`, {
		method: 'GET',
		headers: {
			'X-WP-Nonce': wfcmData.restNonce
		}
	});

	// Send the request.
	fetch( request )
		.then( response => response.json() )
		.then( data => {
			if ( data.success ) {
				document.getElementById( `wfcm-admin-notice-${noticeId}` ).style.display = 'none';
			}
		})
		.catch( error => {
			console.log( error );
		});
}
