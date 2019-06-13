/**
 * Scan Modal.
 */
import React, { Component } from 'react';
import Modal from 'react-modal';
import fileEvents from '../helper/FileEvents';

export default class ScanModal extends Component {

	/**
	 * Constructor.
	 */
	constructor() {
		super();

		this.state = {
			modalIsOpen: true,
			modalMessage: wfcmFileChanges.scanModal.initialMsg
		};

		this.openModal = this.openModal.bind( this );
		this.closeModal = this.closeModal.bind( this );
		this.startScan = this.startScan.bind( this );
	}

	/**
	 * Open modal.
	 */
	openModal() {
		this.setState({modalIsOpen: true});
	}

	/**
	 * Close modal.
	 */
	closeModal() {
		this.setState({modalIsOpen: false});

		const requestUrl = `${wfcmFileChanges.scanModal.adminAjax}?action=wfcm_dismiss_instant_scan_modal&security=${wfcmFileChanges.security}`;
		let requestParams = { method: 'GET' };
		fetch( requestUrl, requestParams );
	}

	/**
	 * Start the scan.
	 */
	async startScan( element ) {
		const targetElement = element.target;
		targetElement.value = wfcmFileChanges.scanModal.scanning;
		targetElement.disabled = true;

		const scanRequest = fileEvents.getRestRequestObject( 'GET', wfcmFileChanges.monitor.start );
		let response = await fetch( scanRequest );
		response = await response.json();

		if ( response ) {
			this.setState({modalMessage: wfcmFileChanges.scanModal.afterScan});
		} else {
			targetElement.value = wfcmFileChanges.scanModal.scanFailed;
		}
	}

	/**
	 * Render the modal.
	 */
	render() {
		return (
			<React.Fragment>
				<Modal isOpen={this.state.modalIsOpen} onRequestClose={this.closeModal} style={modalStyles} contentLabel={wfcmFileChanges.scanModal.scanNow}>
					<div className="wfcm-modal-header">
						<h2>{wfcmFileChanges.scanModal.scanNow}</h2>
						<button className="button" onClick={this.closeModal}><span class="dashicons dashicons-no-alt"></span></button>
					</div>
					<div className="wfcm-modal-body">
						<p>{this.state.modalMessage}</p>
						<p>
							<input type="button" className="button-primary" value={wfcmFileChanges.scanModal.scanNow} onClick={this.startScan} />&nbsp;
							<input type="button" className="button" value={wfcmFileChanges.scanModal.scanDismiss} onClick={this.closeModal} />
						</p>
					</div>
				</Modal>
			</React.Fragment>
		);
	}
}

const modalStyles = {
	content: {
		top: '35%',
		left: '50%',
		right: 'auto',
		bottom: 'auto',
		marginRight: '-50%',
		transform: 'translate(-40%, -30%)',
		border: 'none',
		borderRadius: '0',
		padding: '0 16px 16px',
		width: '500px'
	}
};

Modal.defaultStyles.overlay.backgroundColor = 'rgba(0,0,0,0.5)';
Modal.setAppElement( '#wfcm-file-changes-view' );
