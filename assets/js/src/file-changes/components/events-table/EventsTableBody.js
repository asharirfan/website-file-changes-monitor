/**
 * Events Table Body
 */

import React, { Component } from 'react';
import EventsTableRow from './EventsTableRow';
import { CreatedEventsContext } from '../context/createdEventsContext';

export default class EventsTableBody extends Component {
	render() {
		if ( 0 < this.props.monitorEvents.length ) {
			return (
				<CreatedEventsContext.Consumer>
					{ ({ events, selectEvent, markEventAsRead, excludeEvent }) => (
						<tbody>
							{ events.map( singleEvent => (
								<EventsTableRow event={singleEvent} selectEvent={selectEvent} markEventAsRead={markEventAsRead} excludeEvent={excludeEvent} />
							) ) }
						</tbody>
					) }
				</CreatedEventsContext.Consumer>
			);
		} else {
			return (
				<tbody><tr><td colSpan="5">No new events!</td></tr></tbody>
			);
		}
	}
};
