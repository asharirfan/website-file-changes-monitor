/**
 * Events Table Head
 */
import React, { Component } from 'react';

export default class EventsTableHead extends Component {

	render() {
		return (
			<thead>
				<td className="check-column"><input type="checkbox" name="select-all" checked={this.props.selectAll} onChange={this.props.selectAllEvents} /></td>
				<th>Path</th>
				<th className="column-event-name">Name</th>
				<th className="column-content-type">Type</th>
				<th className="column-event-action">Mark as Read</th>
				<th className="column-event-action">Add to Exclude</th>
				<th className="column-event-content"></th>
			</thead>
		);
	}
}
