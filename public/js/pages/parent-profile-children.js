/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 15);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/helpers.js":
/*!*********************************!*\
  !*** ./resources/js/helpers.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('input[type=file]').on('change', function (e) {
    var name = $(this).val().split('\\').pop();
    $(this).parent().find('.file-name').html(name);
  });
});
tripsittaTable = {
  table_id: "",
  createDuplicatableRow: function createDuplicatableRow() {
    var table = $('#' + tripsittaTable.table_id + ' tbody');
    var cloned = table.find('tr:first-child').clone();
    cloned.find('input, select').each(function (index, value) {
      $(this).attr('name', $(this).attr('name').replace('0', 'tmp')).val('').attr('disabled', true);
    });
    table.find('.add_more').before(cloned.addClass('cloned').hide());
  },
  addRow: function addRow() {
    var table = $('#' + tripsittaTable.table_id);
    var clone_duplicatable_row = table.find('.cloned').clone().show().removeClass('cloned');
    var row_index = table.find("tr.add_more").index();
    clone_duplicatable_row.find('input, select').each(function (index, value) {
      $(this).attr('name', $(this).attr('name').replace('tmp', row_index)).attr('disabled', false);
    });
    table.find('.add_more').before(clone_duplicatable_row);
  },
  deleteRow: function deleteRow(row_index) {
    $('#' + tripsittaTable.table_id).find('tbody tr:eq(' + row_index + ')').remove();
  },
  deleteAllRows: function deleteAllRows() {
    $('#' + tripsittaTable.table_id).find('tbody tr').not('.add_more').not('.cloned').remove();
  }
};
tripsittaModal = {
  modal_id: "",
  toggleModal: function toggleModal() {
    $(tripsittaModal.modal_id).toggleClass('is-active');
  },
  makeModal: function makeModal(content) {
    $('body').append(content);
  },
  removeModal: function removeModal() {
    $(tripsittaModal.modal_id).remove();
  }
};
tripsittaCommon = {
  delay: function delay(fn, ms) {
    var timer = 0;
    return function () {
      clearTimeout(timer);

      for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }

      timer = setTimeout(fn.bind.apply(fn, [this].concat(args)), ms || 0);
    };
  }
};
tripsittaButtonPicker = {
  wrapper_id: "",
  selected_value: "",
  toggleSelect: function toggleSelect(button) {
    tripsittaButtonPicker.clearSelection();
    tripsittaButtonPicker.selected_value = button.data('value');
    button.toggleClass('is-selected').toggleClass('is-dark');
  },
  clearSelection: function clearSelection() {
    $('#' + tripsittaButtonPicker.wrapper_id).find('.button').removeClass('is-selected').removeClass('is-dark');
  },
  updateHiddenField: function updateHiddenField(button, hidden_field_el) {
    var new_val = button.data('value');
    hidden_field_el.val(new_val);
  }
};

/***/ }),

/***/ "./resources/js/pages/parent-profile-children.js":
/*!*******************************************************!*\
  !*** ./resources/js/pages/parent-profile-children.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../helpers.js */ "./resources/js/helpers.js");

$(document).ready(function () {
  var childrenTable = tripsittaTable;
  childrenTable.table_id = 'table_children';
  childrenTable.createDuplicatableRow();
  $('#' + childrenTable.table_id).on('click', '.add_more', function (e) {
    childrenTable.addRow();
  }).on('click', '.delete-one-row', function (e) {
    var row_index = $(this).closest('tr').index();
    childrenTable.deleteRow(row_index);
  }).on('click', '.delete-all-rows', function (e) {
    childrenTable.deleteAllRows();
  });
});

/***/ }),

/***/ 15:
/*!*************************************************************!*\
  !*** multi ./resources/js/pages/parent-profile-children.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\laragon\www\tripsitta\tripsitta\resources\js\pages\parent-profile-children.js */"./resources/js/pages/parent-profile-children.js");


/***/ })

/******/ });