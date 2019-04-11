/**
 * Events Table.
 */

import React from 'react';
import { CreatedEventsContext } from '../context/createdEventsContext';
import EventsTable from './EventsTable';

export default () => (
	<CreatedEventsContext.Consumer>
		{ ({events, selectAll, getCreatedFileEvents, selectEvent, selectAllEvents}) => (
			<EventsTable
				events={events}
				selectAll={selectAll}
				getCreatedFileEvents={getCreatedFileEvents}
				selectEvent={selectEvent}
				selectAllEvents={selectAllEvents}
			/>
		) }
	</CreatedEventsContext.Consumer>
);
