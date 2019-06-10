/**
 * Events Table Head
 */
import React, { Component } from 'react';

export default class EventsTableHead extends Component {

	render() {
		return (
			<thead>
				<td className="check-column"><input type="checkbox" name="select-all" checked={this.props.selectAll} onChange={this.props.selectAllEvents} /></td>
				<th>{wfcmFileChanges.tableHead.path}</th>
				<th className="column-event-name">{wfcmFileChanges.tableHead.name}</th>
				<th className="column-content-type">{wfcmFileChanges.tableHead.type}</th>
				<th className="column-event-action">{wfcmFileChanges.tableHead.markAsRead}</th>
				<th className="column-event-exclude">{wfcmFileChanges.tableHead.exclude}</th>
				<th className="column-event-content"></th>
			</thead>
		);
	}
}
