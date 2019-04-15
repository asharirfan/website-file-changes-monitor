/**
 * Created Files Table
 */

import React, { Component } from 'react';
import EventsTable from '../events-table';
import Navigation from '../navigation';
import { AddedEventsProvider } from '../context/AddedEventsContext';

export default class AddedFilesTable extends Component {
	render() {
		return (
			<section>
				<AddedEventsProvider>
					<h2>Added Files</h2>
					<Navigation />
					<EventsTable />
				</AddedEventsProvider>
			</section>
		);
	}
}
