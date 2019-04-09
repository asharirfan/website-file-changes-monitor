/**
 * Modified Files Table
 */

import React, { Component } from 'react';
import EventsTable from './components/EventsTable';

export default class ModifiedFilesTable extends Component {

	/**
	 * Query events from WordPress.
	 */
	getModifiedFileEvents() {
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
			<h2>Modified Files</h2>,
			<EventsTable monitorEvents={this.getModifiedFileEvents()} />
		];
	}
}
