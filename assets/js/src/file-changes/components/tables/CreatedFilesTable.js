/**
 * Created Files Table
 */

import React, { Component } from 'react';
import EventsTable from '../events-table';
import BulkAction from '../bulk-actions';
import { CreatedEventsProvider } from '../context/createdEventsContext';

export default class CreatedFilesTable extends Component {
	render() {
		return (
			<section>
				<CreatedEventsProvider>
					<h2>Created Files</h2>
					<BulkAction />
					<EventsTable />
				</CreatedEventsProvider>
			</section>
		);
	}
}
