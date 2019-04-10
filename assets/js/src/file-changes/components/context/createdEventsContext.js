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
			status: 'initial'
		};
	}

	selectAll( id ) {
		this.setState({ events: this.state.events.map( event => {
			if ( 'all' === id || event.id === id ) {
				event.checked = ! event.checked;
			}
			return event;
		}) });
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
					selectAll: this.selectAll.bind( this )
				}}
			>
				{this.props.children}
			</CreatedEventsContext.Provider>
		);
	}
}
