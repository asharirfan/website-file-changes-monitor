/**
 * Common JS
 */
window.addEventListener( 'load', function() {

	const dismissBtns = document.querySelectorAll( '.wfm-admin-notice .button' );

	// Add Exclude Item.
	[ ...dismissBtns ].forEach( dismissBtn => {
		dismissBtn.addEventListener( 'click', wfmDismissAdminNotice );
	});
});

/**
 * Send dismiss request to remove admin notice.
 *
 * @param {Event} e Event object.
 */
function wfmDismissAdminNotice( e ) {

	const noticeId = e.target.dataset.noticeId;

	// Rest request object.
	const request = new Request( `${wfmData.restAdminEndpoint}/${noticeId}`, {
		method: 'GET',
		headers: {
			'X-WP-Nonce': wfmData.restNonce
		}
	});

	// Send the request.
	fetch( request )
		.then( response => response.json() )
		.then( data => {
			if ( data.success ) {
				document.getElementById( `wfm-admin-notice-${noticeId}` ).style.display = 'none';
			}
		})
		.catch( error => {
			console.log( error );
		});
}
