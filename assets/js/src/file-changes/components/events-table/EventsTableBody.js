/**
 * Events Table Body
 */

import React, { Component } from 'react';
import EventsTableRow from './EventsTableRow';
import { AddedEventsContext } from '../context/AddedEventsContext';

export default class EventsTableBody extends Component {
	render() {
		if ( 0 < this.props.monitorEvents.length ) {
			return (
				<AddedEventsContext.Consumer>
					{ ({ events, selectEvent, markEventAsRead, excludeEvent }) => (
						<tbody>
							{ events.map( singleEvent => (
								<EventsTableRow event={singleEvent} selectEvent={selectEvent} markEventAsRead={markEventAsRead} excludeEvent={excludeEvent} />
							) ) }
						</tbody>
					) }
				</AddedEventsContext.Consumer>
			);
		} else {
			return (
				<tbody><tr><td colSpan="5">No new events!</td></tr></tbody>
			);
		}
	}
};
