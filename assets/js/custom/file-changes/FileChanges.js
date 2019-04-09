/**
 * File Changes Main.
 */
import React, { Component } from 'react';
import CreatedFilesTable from './CreatedFilesTable';
import DeletedFilesTable from './DeletedFilesTable';
import ModifiedFilesTable from './ModifiedFilesTable';

export default class FileChanges extends Component {
	render() {
		return (
			<div>
				<h1>File Changes Monitor</h1>
				<CreatedFilesTable />
				<DeletedFilesTable />
				<ModifiedFilesTable />
			</div>
		);
	}
}
