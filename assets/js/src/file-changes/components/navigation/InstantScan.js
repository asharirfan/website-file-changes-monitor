/**
 * Instant Scan.
 */
import React, { Component } from 'react';
import ScanErrorModal from '../modal/ScanErrorModal';

export default class InstantScan extends Component {

	constructor( props ) {
		super( props );

		this.state = {
			scanning: false,
			scanFailed: false,
			scanBtnValue: wfcmFileChanges.instantScan.scanNow,
			lastScanTimestamp: wfcmFileChanges.instantScan.lastScanTime
		};
	}

	/**
	 * Start manual scan.
	 */
	async startScan() {
		this.setState({
			scanning: true,
			scanBtnValue: wfcmFileChanges.instantScan.scanning
		});

		const response = await this.props.startInstantScan();

		if ( response ) {
			this.setState({
				scanning: false,
				scanBtnValue: wfcmFileChanges.instantScan.scanNow,
				lastScanTimestamp: response
			});
		} else {
			this.setState({
				scanFailed: true,
				scanBtnValue: wfcmFileChanges.instantScan.scanFailed
			});
		}
	}

	/**
	 * Component render.
	 */
	render() {
		return (
			<div className="alignleft actions">
				<input type="submit" className="button-primary" value={this.state.scanBtnValue} onClick={this.startScan.bind( this )} disabled={this.state.scanning} />
				{
					this.state.lastScanTimestamp ?
						<span id="last-scan-timestamp">{wfcmFileChanges.instantScan.lastScan}: {this.state.lastScanTimestamp}</span> :
						false
				}
				{
					this.state.scanFailed ?
						<ScanErrorModal /> :
						null
				}
			</div>
		);
	}
}
