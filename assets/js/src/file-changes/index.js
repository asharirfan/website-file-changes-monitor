/**
 * File Changes Main.
 */
import React, { Component } from 'react';
import CreatedFilesTable from './components/tables/CreatedFilesTable';
import DeletedFilesTable from './components/tables/DeletedFilesTable';
import ModifiedFilesTable from './components/tables/ModifiedFilesTable';

export default class FileChanges extends Component {
	render() {
		return (
			<div>
				<h1>File Changes Monitor</h1>
				<CreatedFilesTable />
				{/* <DeletedFilesTable />
				<ModifiedFilesTable /> */}
			</div>
		);
	}
}
