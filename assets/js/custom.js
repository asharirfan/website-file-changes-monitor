"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

/**
 * Settings JS.
 */
window.addEventListener('load', function () {
  var $ = document.querySelector.bind(document);
  var keepLog = document.querySelectorAll('input[name="wpfcm-settings[keep-log]"]');
  var frequencySelect = $('select[name="wpfcm-settings[scan-frequency]"]');
  var scanDay = $('select[name="wpfcm-settings[scan-day]"]').parentNode;
  var scanDate = $('select[name="wpfcm-settings[scan-date]"]').parentNode;
  var excludeAdd = document.querySelectorAll('.wpfcm-files-container .add');
  var excludeRemove = document.querySelectorAll('.wpfcm-files-container .remove'); // Frequency handler.

  frequencySelect.addEventListener('change', function () {
    showScanFields(this.value);
  }); // Manage appearance on load.

  showScanFields(frequencySelect.value);
  /**
   * Show Scan Time fields according to selected frequency.
   *
   * @param {string} frequency - Scan frequency.
   */

  function showScanFields(frequency) {
    scanDay.classList.add('hidden');
    scanDate.classList.add('hidden');

    if ('weekly' === frequency) {
      scanDay.classList.remove('hidden');
    } else if ('monthly' === frequency) {
      scanDate.classList.remove('hidden');
    }
  } // Add Exclude Item.


  _toConsumableArray(excludeAdd).forEach(function (excludeAddButton) {
    excludeAddButton.addEventListener('click', addToExcludeList);
  }); // Remove Exclude Item(s).


  _toConsumableArray(excludeRemove).forEach(function (excludeRemoveButton) {
    excludeRemoveButton.addEventListener('click', removeFromExcludeList);
  });
  /**
   * Add item to exclude list.
   *
   * @param {Event} e Event object.
   */


  function addToExcludeList(e) {
    var pattern = '';
    var excludeType = e.target.dataset.excludeType;

    if ('dirs' === excludeType) {
      pattern = /^\s*[a-z-._\d,\s/]+\s*$/i;
    } else if ('files' === excludeType) {
      pattern = /^\s*[a-z-._\d,\s]+\s*$/i;
    } else if ('exts' === excludeType) {
      pattern = /^\s*[a-z-._\d,\s]+\s*$/i;
    }

    var excludeList = $("#wpfcm-exclude-".concat(excludeType, "-list"));
    var excludeNameInput = e.target.parentNode.querySelector('.name');
    var excludeName = excludeNameInput.value;

    if (excludeName.match(pattern)) {
      var excludeItem = document.createElement('span');
      var excludeItemInput = document.createElement('input');
      var excludeItemLabel = document.createElement('label');
      excludeItemInput.type = 'checkbox';
      excludeItemInput.checked = true;
      excludeItemInput.name = "wpfcm-settings[scan-exclude-".concat(excludeType, "][]");
      excludeItemInput.id = excludeName;
      excludeItemInput.value = excludeName;
      excludeItemLabel.setAttribute('for', excludeName);
      excludeItemLabel.innerHTML = excludeName;
      excludeItem.appendChild(excludeItemInput);
      excludeItem.appendChild(excludeItemLabel);
      excludeList.appendChild(excludeItem);
      excludeNameInput.value = '';
    } else {
      if ('dirs' === excludeType) {
        alert(wpfcmData.dirInvalid);
      } else if ('files' === excludeType) {
        alert(wpfcmData.fileInvalid);
      } else if ('exts' === excludeType) {
        alert(wpfcmData.extensionInvalid);
      }
    }
  }
  /**
   * Remove item from exclude list.
   *
   * @param {Event} e Event object.
   */


  function removeFromExcludeList(e) {
    var excludeItems = _toConsumableArray(e.target.parentNode.querySelectorAll('.exclude-list input[type=checkbox]'));

    var removedValues = [];

    for (var index = 0; index < excludeItems.length; index++) {
      if (!excludeItems[index].checked) {
        removedValues.push(excludeItems[index].value);
      }
    }

    if (removedValues.length) {
      for (var _index = 0; _index < removedValues.length; _index++) {
        var excludeItem = $('input[value="' + removedValues[_index] + '"]');

        if (excludeItem) {
          excludeItem.parentNode.remove();
        }
      }
    }
  } // Update settings state when keep log options change.


  _toConsumableArray(keepLog).forEach(function (toggle) {
    toggle.addEventListener('change', function () {
      toggleSettings(this.value);
    });
  });
  /**
   * Toggle Plugin Settings State.
   *
   * @param {string} settingValue - Keep log setting value.
   */


  function toggleSettings(settingValue) {
    var settingFields = _toConsumableArray(document.querySelectorAll('.wpfcm-table fieldset'));

    settingFields.forEach(function (setting) {
      if ('no' === settingValue) {
        setting.disabled = true;
      } else {
        setting.disabled = false;
      }
    });
  }
});