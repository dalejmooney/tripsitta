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
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/book-now.js":
/*!****************************************!*\
  !*** ./resources/js/pages/book-now.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var table = $('.table-children');
  $('input[name*="[dob]"]').mask('00/00/0000');
  table.on('click', '.add-one-more', function (e) {
    addNewRow(table);
  }).on('click', '.delete-one-row', function (e) {
    var row_index = $(this).closest('tr').index();
    deleteSelectedRow(row_index, table);
    toggleAllowedChildrenNotification();
  }).on('click', '.child-picker', function (e) {
    tripsittaModal.modal_id = '#saved_children';
    tripsittaModal.toggleModal();
    var row_index = $(this).closest('tr').index();
    $(tripsittaModal.modal_id).data('triggered_by', row_index);
  }).on('keyup', 'input[name*=dob]', tripsittaCommon.delay(toggleAllowedChildrenNotification, 500));
  $('.modal-close').on('click', function (e) {
    e.preventDefault();
    tripsittaModal.modal_id = '#saved_children';
    tripsittaModal.toggleModal();
    $(tripsittaModal.modal_id).data('triggered_by', '');
  });
  $('#continue_booking').on('click', function (e) {
    e.preventDefault();
    $('#booking_details_form').submit();
  });
  $("#booking_details_form").validate({
    rules: {
      "children[0][name]": {
        required: true
      },
      "children[0][dob]": {
        required: true,
        dateITA: true,
        dobRange: true
      }
    },
    submitHandler: function submitHandler(form) {
      form.submit();
    },
    highlight: function highlight(element, errorClass, validClass) {
      $(element).addClass(errorClass).removeClass(validClass);
    },
    unhighlight: function unhighlight(element, errorClass, validClass) {
      $(element).removeClass(errorClass).addClass(validClass);
    },
    errorClass: 'is-danger',
    errorElement: 'p',
    errorPlacement: function errorPlacement(error, element) {
      $(element).parent().append(error).addClass('has-text-danger');
    }
  });

  function toggleAllowedChildrenNotification() {
    $('.children_notification').remove();

    if (allowedChildrenCheck($('input[name*="[dob]"]:visible')) === false) {
      $('#children_subtitle').after("<div class=\"notification is-danger children_notification\">It looks like you need more than one babysitter to help with your children. Please either proceed with 2 separate booking or contact us and we'll help.</div>");
    }
  }

  function allowedChildrenCheck(children) {
    var groups = [];
    $.each(children, function (key, child) {
      var dob = $(child).val();
      if (dob === '' || !moment(dob, 'DD/MM/YYYY').isValid()) return;
      var child_group = calculateAgeGroup(dob);
      groups.push(child_group);
    });
    var count = {};
    groups.forEach(function (i) {
      count[i] = (count[i] || 0) + 1;
    });
    if (count['infant'] > 2) return false;
    if (count['infant'] === 2 && children.length > 2) return false;
    return true;
  }

  function calculateAgeGroup(dob) {
    dob = moment(dob, 'DD/MM/YYYY');
    var today = moment();
    var duration = moment.duration(today.diff(dob));

    if (duration.asMonths() <= 18) {
      return 'infant';
    } else if (duration.asMonths() <= 24) {
      return 'small_baby';
    } else if (duration.asYears() <= 4) {
      return 'baby';
    }

    return 'child';
  }

  function addNewRow(output_el) {
    var template = output_el.find('.hidden-template');
    var clone = template.clone().removeClass('hidden-template').removeClass('is-hidden');
    var row_index = output_el.find("tr.add-one-more").index();
    var total_row_count = output_el.find('tr').length - 3;
    if (total_row_count === 4) return;
    output_el.find('.add-one-more a').attr('disabled', false);
    clone.find('input').each(function (index, value) {
      $(this).attr('name', $(this).attr('name').replace('tmp', row_index)).attr('disabled', false);
    });
    output_el.find("tr.add-one-more").before(clone); // count is done before new row added

    var price_options = $('#price_estimate').data('prices');
    var child_string = 'child';
    if (total_row_count + 1 > 1) child_string = 'children';
    $('#price_estimate').html('€' + price_options[total_row_count].toFixed(2) + ' for ' + (total_row_count + 1) + ' ' + child_string);
    if (total_row_count === 3) output_el.find('.add-one-more a').attr('disabled', 'disabled');
    $('input[name*="[dob]"]').mask('00/00/0000');
    $("input[name*='[name]']:visible").each(function () {
      $(this).rules('add', {
        required: true,
        minlength: 3
      });
    });
    $("input[name*='[dob]']:visible").each(function () {
      $(this).rules('add', {
        required: true,
        dateITA: true,
        dobRange: true
      });
    });
  }

  function deleteSelectedRow(row_index, output_el) {
    var total_row_count = output_el.find('tr').length - 3;
    if (total_row_count === 1) return;
    output_el.find('tbody tr:eq(' + row_index + ')').remove();
    output_el.find('.add-one-more a').attr('disabled', false);
    var price_options = $('#price_estimate').data('prices');
    $('#price_estimate').html('€' + price_options[total_row_count - 2].toFixed(2) + ' for ' + (total_row_count - 1) + ' child');
  }

  $('#saved_children .button').on('click', pickChildFromList);

  function pickChildFromList() {
    var el = $(this).parents('tr');
    tripsittaModal.modal_id = '#saved_children';
    var row_index_to_update = $(tripsittaModal.modal_id).data('triggered_by');
    var table_row = table.find('tbody tr:eq(' + row_index_to_update + ')');
    table_row.find('input[name="children[' + row_index_to_update + '][name]"]').val(el.data('name')).prop('readonly', true);
    table_row.find('input[name="children[' + row_index_to_update + '][dob]"]').val(el.data('dob')).prop('readonly', true);
    tripsittaModal.toggleModal();
    toggleAllowedChildrenNotification();
  }
});

/***/ }),

/***/ 8:
/*!**********************************************!*\
  !*** multi ./resources/js/pages/book-now.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\laragon\www\tripsitta\tripsitta\resources\js\pages\book-now.js */"./resources/js/pages/book-now.js");


/***/ })

/******/ });