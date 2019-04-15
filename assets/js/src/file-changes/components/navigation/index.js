/**
 * Events Table Bulk Actions.
 */
import React from 'react';
import { CreatedEventsContext } from '../context/createdEventsContext';
import BulkActions from './BulkActions';
import Pagination from './Pagination';

const Navigation = () => {
	return (
		<CreatedEventsContext.Consumer>
			{ ({totalItems, maxPages, paged, goToPage, handleBulkAction}) => (
				<div className="tablenav top">
					<BulkActions handleBulkAction={handleBulkAction} />
					<Pagination totalItems={totalItems} maxPages={maxPages} paged={paged} goToPage={goToPage} />
				</div>
			) }
		</CreatedEventsContext.Consumer>
	);
};

export default Navigation;
