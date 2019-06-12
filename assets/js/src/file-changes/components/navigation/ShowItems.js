/**
 * Show Items.
 */
import React, { Component } from 'react';

export default class ShowItems extends Component {

	handleShowItems( element ) {
		const items = Number( element.target.value );
		this.props.handleShowItems( items );
	}

	render() {
		return (
			<div className="alignleft actions">
				<label htmlFor="show-items" className="screen-reader-text">Show items</label>
				<select id="show-items" onChange={this.handleShowItems.bind( this )}>
					<option value="-1">Show items</option>
					<option value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			</div>
		);
	}
}
