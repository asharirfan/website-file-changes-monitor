/**
 * Events Table Body
 */

import React, { Component } from 'react';
import EventsTableRow from './EventsTableRow';

export default class EventsTableBody extends Component {
	render() {
		if ( 0 < this.props.monitorEvents.length ) {
			return this.props.monitorEvents.map( singleEvent => (
				<EventsTableRow event={singleEvent} />
			) );
		} else {
			return (
				<tr><td colSpan="5">No new events!</td></tr>
			);
		}
	}
};
