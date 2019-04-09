/**
 * Events Table Rows.
 */
import React, { Component } from 'react';

export default class EventsTableRows extends Component {
	render() {
		if ( 0 < this.props.monitorEvents.length ) {
			return this.props.monitorEvents.map( ( singleEvent ) => (
				<tr>
					<td><input type="checkbox" name="fileEvent[]" value={singleEvent.id} checked={singleEvent.checked} /></td>
					<td>{singleEvent.path}</td>
					<td>{singleEvent.filename}</td>
					<td><input className="button-primary" type="button" value="Mark as Read" /></td>
					<td><input className="button-primary" type="button" value="Ignore" /></td>
				</tr>
			) );
		} else {
			return (
				<tr><td colSpan="5">No new events!</td></tr>
			);
		}
	}
}
