/**
 * Events Table.
 */

import React from 'react';
import { CreatedEventsContext } from '../context/createdEventsContext';
import EventsTable from './EventsTable';

export default () => (
	<CreatedEventsContext.Consumer>
		{ ({events, selectAll, getFileEvents, selectAllEvents}) => (
			<EventsTable
				events={events}
				selectAll={selectAll}
				getFileEvents={getFileEvents}
				selectAllEvents={selectAllEvents}
			/>
		) }
	</CreatedEventsContext.Consumer>
);
