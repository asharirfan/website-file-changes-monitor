/**
 * Events Table Bulk Actions.
 */
import React from 'react';
import { CreatedEventsContext } from '../context/createdEventsContext';
import BulkActions from './BulkActions';

 export default () => {
	return (
		<CreatedEventsContext.Consumer>
			{ ({handleBulkAction}) => (
				<BulkActions handleBulkAction={handleBulkAction} />
			) }
		</CreatedEventsContext.Consumer>
	);
};
