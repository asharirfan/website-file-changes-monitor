/**
 * Events Table.
 */

import React from 'react';
import { AddedEventsContext } from '../context/AddedEventsContext';
import EventsTable from './EventsTable';

export default () => (
	<AddedEventsContext.Consumer>
		{ ({events, selectAll, getFileEvents, selectAllEvents}) => (
			<EventsTable
				events={events}
				selectAll={selectAll}
				getFileEvents={getFileEvents}
				selectAllEvents={selectAllEvents}
			/>
		) }
	</AddedEventsContext.Consumer>
);
