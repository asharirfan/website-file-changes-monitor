/**
 * Created File Events.
 */

function getRestRequestObject( method, url ) {
	const request = new Request( url, { // eslint-disable-line no-undef
		method: method,
		headers: {
			'X-WP-Nonce': wpfcmFileChanges.security // eslint-disable-line no-undef
		}
	});
	return request;
}

async function getEvents( eventType, paged ) {
	const requestUrl = `${wpfcmFileChanges.fileEvents.get}/${eventType}?paged=${paged}`;
	const request = getRestRequestObject( 'GET', requestUrl ); // Get REST request object.

	// Send the request.
	let response = await fetch( request );
	let events = await response.json();
	return events;
}

async function markEventAsRead( id ) {
	const requestUrl = `${wpfcmFileChanges.fileEvents.delete}/${id}`;
	const request = new Request( requestUrl, { // eslint-disable-line no-undef
		method: 'DELETE',
		headers: {
			'X-WP-Nonce': wpfcmFileChanges.security // eslint-disable-line no-undef
		}
	});

	// Send the request.
	let response = await fetch( request );
	response = await response.json();
	return response;
}

async function excludeEvent( id ) {
	const requestUrl = `${wpfcmFileChanges.fileEvents.delete}/${id}`;
	const request = new Request( requestUrl, { // eslint-disable-line no-undef
		method: 'DELETE',
		headers: {
			'X-WP-Nonce': wpfcmFileChanges.security // eslint-disable-line no-undef
		},
		body: JSON.stringify({
			exclude: true
		})
	});

	// Send the request.
	let response = await fetch( request );
	response = await response.json();
	return response;
}

export default {
	getEvents,
	markEventAsRead,
	excludeEvent
};
