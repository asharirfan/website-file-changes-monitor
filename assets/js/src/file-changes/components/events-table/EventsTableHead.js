/**
 * Events Table Head
 */
import React, { Component } from 'react';

export default class EventsTableHead extends Component {

	render() {
		return (
			<thead>
				<td className="check-column"><input type="checkbox" name="select-all" checked={this.props.selectAll} onChange={this.props.selectAllEvents} /></td>
				<th>File Path</th>
				<th>Filename</th>
				<th className="column-author"><input type="button" value="Mark as Read" /></th>
				<th className="column-author"><input type="button" value="Ignore" /></th>
			</thead>
		);
	}
}
