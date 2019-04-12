/**
 * Bulk Actions.
 */
import React, { Component } from 'react';

export default class BulkActions extends Component {

	constructor( props ) {
		super( props );

		this.state = {
			selectedAction: '-1'
		};
	}

	selectAction( e ) {
		const {value} = e.target;
		this.setState({selectedAction: value});
	}

	render() {
		return (
			<div className="tablenav top">
				<div className="alignleft actions">
					<label htmlFor="bulk-action-selector-top" className="screen-reader-text">Select bulk action</label>
					<select id="bulk-action-selector-top" name="bulk-action" onChange={this.selectAction.bind( this )}>
						<option value="-1">Bulk Actions</option>
						<option value="mark-as-read">Mark as Read</option>
						<option value="exclude">Exclude</option>
					</select>
					<input type="submit" className="button action" value="Apply" onClick={this.props.handleBulkAction.bind( this, this.state.selectedAction )} />
				</div>
			</div>
		);
	}
}
