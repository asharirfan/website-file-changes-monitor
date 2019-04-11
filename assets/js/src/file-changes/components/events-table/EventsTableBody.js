/**
 * Events Table Body
 */

import React, { Component } from 'react';
import EventsTableRow from './EventsTableRow';

export default class EventsTableBody extends Component {
	render() {
		if ( 0 < this.props.monitorEvents.length ) {
			return (
				<tbody>
					{ this.props.monitorEvents.map( singleEvent => (
						<EventsTableRow event={singleEvent} selectEvent={this.props.selectEvent} />
					) ) }
				</tbody>
			);
		} else {
			return (
				<tbody><tr><td colSpan="5">No new events!</td></tr></tbody>
			);
		}
	}
};
