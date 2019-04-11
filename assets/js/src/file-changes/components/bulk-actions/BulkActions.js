/**
 * Bulk Actions.
 */
import React from 'react';

export default function BulkActions() {
	return (
		<div className="tablenav top">
			<div className="alignleft actions">
				<label htmlFor="bulk-action-selector-top" className="screen-reader-text">Select bulk action</label>
				<select id="bulk-action-selector-top">
					<option value="-1">Bulk Actions</option>
					<option value="mark-read">Mark as Read</option>
					<option value="exclude">Exclude</option>
				</select>
				<input type="submit" className="button action" value="Apply" />
			</div>
		</div>
	);
}
