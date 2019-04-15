/**
 * Created Events Provider
 */
import React, { Component } from 'react';
import FileEvents from '../helper/FileEvents';

export const AddedEventsContext = React.createContext();

export class AddedEventsProvider extends Component {

	/**
	 * Constructor.
	 *
	 * @param {array} props Component props.
	 */
	constructor( props ) {
		super( props );

		this.state = {
			events: [],
			selectAll: false,
			totalItems: 0,
			maxPages: 1,
			paged: 1
		};
	}

	/**
	 * Select all events.
	 */
	selectAllEvents() {
		this.setState({ selectAll: ! this.state.selectAll }); // Change the state of select all.

		// Change states of every event.
		this.setState({ events: this.state.events.map( event => {
			event.checked = ! this.state.selectAll;
			return event;
		}) });
	}

	/**
	 * Select an event.
	 *
	 * @param {string|int} id Event id.
	 */
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

	/**
	 * Query events from WP.
	 */
	async getFileEvents( paged = false ) {
		if ( false === paged ) {
			paged = this.state.paged;
		}

		const response = await FileEvents.getEvents( 'added', paged );

		this.setState({
			events: response.events,
			totalItems: response.total,
			maxPages: response.max_num_pages,
			paged: paged
		});
	}

	/**
	 * Mark event as read.
	 *
	 * @param {int} eventId Event id.
	 */
	async markEventAsRead( eventId ) {
		const response = await FileEvents.markEventAsRead( eventId );

		if ( response.success ) {
			let events = [ ...this.state.events ];
			let eventIndex = false;

			for ( const [ index, event ] of events.entries() ) {
				if ( event.id === eventId ) {
					eventIndex = index;
				}
			}

			// Remove the found index from state.
			if ( false !== eventIndex ) {
				events.splice( eventIndex, 1 );
				this.setState({events: events});
			}
		}
	}

	/**
	 * Add event to exclude list.
	 *
	 * @param {int} eventId Event id.
	 */
	async excludeEvent( eventId ) {
		const response = await FileEvents.excludeEvent( eventId );

		if ( response.success ) {
			let events = [ ...this.state.events ];
			let eventIndex = false;

			for ( const [ index, event ] of events.entries() ) {
				if ( event.id === eventId ) {
					eventIndex = index;
				}
			}

			// Remove the found index from state.
			if ( false !== eventIndex ) {
				events.splice( eventIndex, 1 );
				this.setState({events: events});
			}
		}
	}

	/**
	 * Handles the bulk actions on events.
	 *
	 * @param {string} action Name of bulk action.
	 */
	async handleBulkAction( action ) {
		let events = [ ...this.state.events ];
		let removedEvents = [];

		for ( const [ index, event ] of events.entries() ) {
			if ( event.checked ) {
				let response;

				if ( 'mark-as-read' === action ) {
					response = await FileEvents.markEventAsRead( event.id );
				} else if ( 'exclude' === action ) {
					response = await FileEvents.excludeEvent( event.id );
				}

				if ( response.success ) {
					removedEvents.push( index );
				}
			}
		}

		if ( 0 < removedEvents.length ) {
			events = events.filter( ( value, index ) => ! removedEvents.includes( index ) );
			this.setState({events: events});
		}
	}

	/**
	 * Events pagination handler.
	 *
	 * @param {int} pageNum Page number.
	 */
	goToPage( pageNum ) {
		this.getFileEvents( pageNum );
	}

	/**
	 * Component render.
	 */
	render() {
		return (
			<AddedEventsContext.Provider
				value={{
					...this.state,
					getFileEvents: this.getFileEvents.bind( this ),
					selectEvent: this.selectEvent.bind( this ),
					selectAllEvents: this.selectAllEvents.bind( this ),
					markEventAsRead: this.markEventAsRead.bind( this ),
					excludeEvent: this.excludeEvent.bind( this ),
					handleBulkAction: this.handleBulkAction.bind( this ),
					goToPage: this.goToPage.bind( this )
				}}
			>
				{this.props.children}
			</AddedEventsContext.Provider>
		);
	}
}
