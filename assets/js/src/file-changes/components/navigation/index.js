/**
 * Events Table Bulk Actions.
 */
import React from 'react';
import { AddedEventsContext } from '../context/AddedEventsContext';
import BulkActions from './BulkActions';
import Pagination from './Pagination';

const Navigation = () => {
	return (
		<AddedEventsContext.Consumer>
			{ ({totalItems, maxPages, paged, goToPage, handleBulkAction}) => (
				<div className="tablenav top">
					<BulkActions handleBulkAction={handleBulkAction} />
					<Pagination totalItems={totalItems} maxPages={maxPages} paged={paged} goToPage={goToPage} />
				</div>
			) }
		</AddedEventsContext.Consumer>
	);
};

export default Navigation;
