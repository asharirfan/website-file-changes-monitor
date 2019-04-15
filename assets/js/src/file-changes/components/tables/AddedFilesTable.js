/**
 * Created Files Table
 */

import React, { Component } from 'react';
import EventsTable from '../events-table';
import Navigation from '../navigation';
import { EventsProvider } from '../context/EventsContext';

export default class AddedFilesTable extends Component {
	render() {
		return (
			<section>
				<EventsProvider eventsType="added">
					<h2>Added Files</h2>
					<Navigation />
					<EventsTable />
				</EventsProvider>
			</section>
		);
	}
}
