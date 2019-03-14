"use strict";

/**
 * Settings JS.
 */
jQuery(document).ready(function () {
  var frequencySelect = jQuery('select[name="wpfcm-settings[scan-frequency]"]');
  var scanDay = jQuery('select[name="wpfcm-settings[scan-day]"]').parent();
  var scanDate = jQuery('select[name="wpfcm-settings[scan-date]"]').parent();
  var excludeName = jQuery('.wpfcm-files-container .name');
  var excludeAdd = jQuery('.wpfcm-files-container .add');
  var excludeRemove = jQuery('.wpfcm-files-container .remove');
  var excludeList = jQuery('.wpfcm-files-container .exclude-list'); // Frequency handler.

  jQuery(frequencySelect).change(function () {
    showScanFields(jQuery(this).val());
  }); // Manage appearance on load.

  showScanFields(frequencySelect.val());
  /**
   * Show Scan Time fields according to selected frequency.
   *
   * @param {string} frequency - Scan frequency.
   */

  function showScanFields(frequency) {
    scanDay.addClass('hidden');
    scanDate.addClass('hidden');

    if ('weekly' === frequency) {
      scanDay.removeClass('hidden');
    } else if ('monthly' === frequency) {
      scanDate.removeClass('hidden');
    }
  }
});