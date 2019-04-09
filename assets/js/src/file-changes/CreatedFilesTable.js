/**
 * Created Files Table
 */

import React, { Component } from 'react';
import EventsTable from './components/EventsTable';

export default class CreatedFilesTable extends Component {

	/**
	 * Query events from WordPress.
	 */
	getCreatedFileEvents() {
		return {
			events: [

				// {
				// 	id: 1,
				// 	path: '/app/public/',
				// 	filename: 'hello.php',
				// 	checked: false
				// },
				// {
				// 	id: 2,
				// 	path: '/app/public/',
				// 	filename: 'wp-hello.php',
				// 	checked: false
				// }
			]
		};
	}

	render() {
		return [
			<h2>Created Files</h2>,
			<EventsTable monitorEvents={this.getCreatedFileEvents()} />
		];
	}
}
