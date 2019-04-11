/**
 * Events Table Rows.
 */
import React, { Component } from 'react';

export default class EventsTableRow extends Component {
	render() {
		const event = this.props.event;
		return (
			<tr>
				<td><input type="checkbox" name="fileEvent[]" value={event.id} checked={event.checked} onChange={this.props.selectEvent.bind( this, event.id )} /></td>
				<td>{event.path}</td>
				<td>{event.filename}</td>
				<td><input className="button-primary" type="button" value="Mark as Read" /></td>
				<td><input className="button-primary" type="button" value="Ignore" /></td>
			</tr>
		);
	}
}
