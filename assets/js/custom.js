"use strict";

/**
 * Settings JS.
 */
jQuery(document).ready(function () {
  var keepLog = jQuery('input[name="wpfcm-settings[keep-log]"]');
  var frequencySelect = jQuery('select[name="wpfcm-settings[scan-frequency]"]');
  var scanDay = jQuery('select[name="wpfcm-settings[scan-day]"]').parent();
  var scanDate = jQuery('select[name="wpfcm-settings[scan-date]"]').parent();
  var excludeAdd = jQuery('.wpfcm-files-container .add');
  var excludeRemove = jQuery('.wpfcm-files-container .remove'); // Frequency handler.

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
  /**
   * Add Exclude Item.
   */


  jQuery(excludeAdd).click(function (event) {
    event.preventDefault();
    var pattern = '';
    var excludeType = jQuery(this).data('exclude-type');

    if ('dirs' === excludeType) {
      pattern = /^\s*[a-z-._\d,\s/]+\s*$/i;
    } else if ('files' === excludeType) {
      pattern = /^\s*[a-z-._\d,\s]+\s*$/i;
    } else if ('exts' === excludeType) {
      pattern = /^\s*[a-z-._\d,\s]+\s*$/i;
    }

    var excludeList = jQuery("#wpfcm-exclude-".concat(excludeType, "-list"));
    var excludeNameInput = jQuery(this).parent().find('.name');
    var excludeName = excludeNameInput.val();

    if (excludeName.match(pattern)) {
      var excludeItem = jQuery('<span></span>');
      var excludeItemInput = jQuery('<input>');
      var excludeItemLabel = jQuery('<label></label>');
      excludeItemInput.prop('type', 'checkbox');
      excludeItemInput.prop('checked', true);
      excludeItemInput.prop('name', "wpfcm-settings[scan-exclude-".concat(excludeType, "][]"));
      excludeItemInput.prop('id', excludeName);
      excludeItemInput.prop('value', excludeName);
      excludeItemLabel.prop('for', excludeName);
      excludeItemLabel.text(excludeName);
      excludeItem.append(excludeItemInput);
      excludeItem.append(excludeItemLabel);
      excludeList.append(excludeItem);
      excludeNameInput.removeAttr('value');
    } else {
      if ('dirs' === excludeType) {
        alert(wpfcmData.dirInvalid);
      } else if ('files' === excludeType) {
        alert(wpfcmData.fileInvalid);
      } else if ('exts' === excludeType) {
        alert(wpfcmData.extensionInvalid);
      }
    }
  });
  /**
   * Remove Exclude Item(s).
   */

  jQuery(excludeRemove).click(function (event) {
    event.preventDefault();
    var excludeItems = jQuery(this).parent().find('.exclude-list input[type=checkbox]');
    var removedValues = [];

    for (var index = 0; index < excludeItems.length; index++) {
      if (!jQuery(excludeItems[index]).is(':checked')) {
        removedValues.push(jQuery(excludeItems[index]).val());
      }
    }

    if (removedValues) {
      for (var _index = 0; _index < removedValues.length; _index++) {
        var excludeItem = jQuery('input[value="' + removedValues[_index] + '"]');

        if (excludeItem) {
          excludeItem.parent().remove();
        }
      }
    }
  }); // Update settings state on change.

  keepLog.change(function () {
    toggleSettings(jQuery(this).val());
  }); // Toggle settings state on page load.

  toggleSettings(keepLog.val());
  /**
   * Toggle Plugin Settings State.
   *
   * @param {string} settingValue - Keep log setting value.
   */

  function toggleSettings(settingValue) {
    var settingFields = jQuery('.wpfcm-table fieldset');

    if ('no' === settingValue) {
      settingFields.attr('disabled', true);
    } else {
      settingFields.removeAttr('disabled');
    }
  }
});