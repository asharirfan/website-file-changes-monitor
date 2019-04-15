/**
 * Modified Files Table
 */

import React, { Component } from 'react';
import EventsTable from '../events-table';
import Navigation from '../navigation';
import { EventsProvider } from '../context/EventsContext';

export default class ModifiedFilesTable extends Component {
	render() {
		return (
			<section>
				<EventsProvider eventsType="modified">
					<h2>Modified Files</h2>
					<Navigation />
					<EventsTable />
				</EventsProvider>
			</section>
		);
	}
}
