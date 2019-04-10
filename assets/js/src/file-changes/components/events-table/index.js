/**
 * Events Table.
 */

import React from 'react';
import { CreatedEventsContext } from '../context/createdEventsContext';
import EventsTable from './EventsTable';

export default () => (
	<CreatedEventsContext.Consumer>
		{ ({events, getCreatedFileEvents, selectAll}) => (
			<EventsTable
				events={events}
				getCreatedFileEvents={getCreatedFileEvents}
				selectAll={selectAll}
			/>
		) }
	</CreatedEventsContext.Consumer>
);
