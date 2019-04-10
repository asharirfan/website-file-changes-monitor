/**
 * Created File Events.
 */

async function getEvents() {

	// Rest request object.
	const request = new Request( wpfcmFileChanges.fileEvents.getCreated, { // eslint-disable-line no-undef
		method: 'GET',
		headers: {
			'X-WP-Nonce': wpfcmFileChanges.security // eslint-disable-line no-undef
		}
	});

	// Send the request.
	let response = await fetch( request );
	let events = await response.json();
	events = JSON.parse( events );
	return events;
}

export default {
	getEvents
};
