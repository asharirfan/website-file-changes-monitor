/**
 * Events Table.
 */

import React, { Component } from 'react';
import EventsTableHead from './EventsTableHead';
import EventsTableBody from './EventsTableBody';

export default class EventsTable extends Component {

	componentDidMount() {
		this.props.getCreatedFileEvents();
	}

	render() {
		return (
			<table className="wp-list-table widefat fixed striped">
				<EventsTableHead selectAllEvents={this.props.selectAllEvents} selectAll={this.props.selectAll} />
				<EventsTableBody monitorEvents={this.props.events} selectEvent={this.props.selectEvent} />
			</table>
		);
	}
}
