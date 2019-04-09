/**
 * Events Table.
 */

import React, { Component } from 'react';
import EventsTableHead from './EventsTableHead';
import EventsTableRows from './EventsTableRows';

export default class EventsTable extends Component {

	constructor( props ) {
		super( props );

		this.state = {
			events: this.props.monitorEvents.events
		};

		// this.selectAll.bind( this );
	}

	selectAll( id ) {
		this.setState({ events: this.state.events.map( event => {
			if ( 'all' === id || event.id === id ) {
				event.checked = ! event.checked;
			}
			return event;
		}) });
	}

	render() {
		return (
			<table className="wp-list-table widefat fixed striped">
				<EventsTableHead selectAll={this.selectAll.bind( this )} />
				<tbody><EventsTableRows monitorEvents={this.state.events} /></tbody>
			</table>
		);
	}
}
