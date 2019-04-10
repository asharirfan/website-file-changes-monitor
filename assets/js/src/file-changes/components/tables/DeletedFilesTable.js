/**
 * Deleted Files Table
 */

import React, { Component } from 'react';
import EventsTable from '../events-table';

export default class DeletedFilesTable extends Component {

	/**
	 * Query events from WordPress.
	 */
	getDeletedFileEvents() {
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
			<h2>Deleted Files</h2>,
			<EventsTable monitorEvents={this.getDeletedFileEvents()} />
		];
	}
}
