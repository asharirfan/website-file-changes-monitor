/**
 * File Changes Main.
 */
import React, { Component } from 'react';
import AddedFilesTable from './components/tables/AddedFilesTable';
import DeletedFilesTable from './components/tables/DeletedFilesTable';
import ModifiedFilesTable from './components/tables/ModifiedFilesTable';

export default class FileChanges extends Component {
	render() {
		return (
			<div>
				<h1>{wfcmFileChanges.pageHead}</h1>
				<AddedFilesTable />
				<DeletedFilesTable />
				<ModifiedFilesTable />
			</div>
		);
	}
}
