/**
 * Events Table Bulk Actions.
 */
import React from 'react';
import { EventsContext } from '../context/EventsContext';
import BulkActions from './BulkActions';
import Pagination from './Pagination';

const Navigation = () => {
	return (
		<EventsContext.Consumer>
			{ ({totalItems, maxPages, paged, goToPage, handleBulkAction}) => (
				<div className="tablenav top">
					<BulkActions handleBulkAction={handleBulkAction} />
					<Pagination totalItems={totalItems} maxPages={maxPages} paged={paged} goToPage={goToPage} />
				</div>
			) }
		</EventsContext.Consumer>
	);
};

export default Navigation;
