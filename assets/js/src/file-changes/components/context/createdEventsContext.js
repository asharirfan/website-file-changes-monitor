/**
 * Created Events Provider
 */
import React, { Component } from 'react';
import createdFiles from '../events/createdFiles';

export const CreatedEventsContext = React.createContext();

export class CreatedEventsProvider extends Component {

	constructor( props ) {
		super( props );

		this.state = {
			events: [],
			selectAll: false
		};
	}

	selectAllEvents() {

		// Change the state of select all.
		this.setState({ selectAll: ! this.state.selectAll });

		// Change states of every event.
		this.setState({ events: this.state.events.map( event => {
			event.checked = ! this.state.selectAll;
			return event;
		}) });
	}

	selectEvent( id ) {
		let allSelected = true;

		this.setState({ events: this.state.events.map( event => {
			event.checked = event.id === id ? ! event.checked : event.checked;
			allSelected = event.checked && allSelected ? allSelected : false;
			return event;
		}) });

		if ( allSelected ) {
			this.setState({ selectAll: true });
		} else {
			this.setState({ selectAll: false });
		}
	}

	async getCreatedFileEvents() {
		const fetchedEvents = await createdFiles.getEvents();
		this.setState({events: fetchedEvents });
	}

	render() {
		return (
			<CreatedEventsContext.Provider
				value={{
					...this.state,
					getCreatedFileEvents: this.getCreatedFileEvents.bind( this ),
					selectEvent: this.selectEvent.bind( this ),
					selectAllEvents: this.selectAllEvents.bind( this )
				}}
			>
				{this.props.children}
			</CreatedEventsContext.Provider>
		);
	}
}
