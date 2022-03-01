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
/******/ 	return __webpack_require__(__webpack_require__.s = 14);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/parent-invoices.js":
/*!***********************************************!*\
  !*** ./resources/js/pages/parent-invoices.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  if (filter_booking_id !== '') {
    filter_table(filter_booking_id);
    $('#search').val(filter_booking_id);
  }

  $('table').on('click', 'tr:not(.table-actions)', function (e) {
    e.preventDefault();
    $(this).next('.table-actions').toggle();
  }).on('click', '.pay-invoice', function (e) {
    e.preventDefault();
    var invoice_id = $(this).data('invoice');
    var modal = "<div class=\"modal\" id=\"pay_invoice\">\n          <div class=\"modal-background\"></div>\n          <div class=\"modal-content\">\n            <div class=\"box\">\n                <p>You'll be redirected to our payment gateway (Stripe) to make the payment. <br />Please confirm below if you want to proceed. </p>\n                <div class=\"buttons has-margin-top-md\">\n                    <a class=\"button is-primary\" id=\"make_payment\" data-invoice=\"" + invoice_id + "\">Proceed to payment</a>\n                    <a class=\"button is-primary is-outlined modal-close-button\">Cancel</a>\n                </div>\n            </div>\n          </div>\n          <button class=\"modal-close is-large\" aria-label=\"close\"></button>\n        </div>\n        ";
    tripsittaModal.makeModal(modal);
    tripsittaModal.modal_id = '#pay_invoice';
    tripsittaModal.toggleModal();
  });
  $('body').on('click', '.modal-close, .modal-close-button', function (e) {
    e.preventDefault();
    tripsittaModal.modal_id = '#pay_invoice';
    tripsittaModal.toggleModal();
    tripsittaModal.removeModal();
  });
  $('body').on('click', '#make_payment', function (e) {
    e.preventDefault();
    $('#make_payment').attr('disabled', 'disabled').addClass('is-loading');
    $('html,body').css("cursor", "progress");
    var invoice_id = $(this).data('invoice');
    $.ajax({
      url: select_invoice_url + '/' + invoice_id,
      type: "GET"
    }).done(function (data) {
      if (data.session === undefined || data.session.length === 0) return;
      $('#errors-container').empty().addClass('is-hidden');
      stripe.redirectToCheckout({
        sessionId: data.session
      }).then(function (result) {
        $('#errors-container').html(result.error.message).removeClass('is-hidden');
        $('#make_payment').attr('disabled', false).removeClass('is-loading');
        tripsittaModal.modal_id = '#pay_invoice';
        tripsittaModal.toggleModal();
        tripsittaModal.removeModal();
        $('html,body').css("cursor", "default");
      });
    }).fail(function (data) {
      var response = JSON.parse(data.responseText);
      var errorString = '<ul>';
      $.each(response.errors, function (key, value) {
        errorString += '<li>' + value + '</li>';
      });
      errorString += '</ul>';
      $('#errors-container').html(errorString).removeClass('is-hidden');
      $('html, body').animate({
        scrollTop: $('#errors-container').offset().top - 80
      }, 1000);
      $('#make_payment').attr('disabled', false).removeClass('is-loading');
      tripsittaModal.modal_id = '#pay_invoice';
      tripsittaModal.toggleModal();
      tripsittaModal.removeModal();
      $('html,body').css("cursor", "default");
    });
  });
  $("#search").on("keyup", function () {
    var value = $(this).val().toLowerCase().trim();
    filter_table(value);
  });

  function filter_table(value) {
    $("table tr").each(function (index) {
      if (index != 0) {
        $row = $(this);
        var id = $row.find("td.table-booking-id").text().toLowerCase().trim();

        if (!id.includes(value)) {
          $(this).hide();
        } else {
          $(this).not('.table-actions').show();
        }
      }
    });
  }
});

/***/ }),

/***/ 14:
/*!*****************************************************!*\
  !*** multi ./resources/js/pages/parent-invoices.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\laragon\www\tripsitta\tripsitta\resources\js\pages\parent-invoices.js */"./resources/js/pages/parent-invoices.js");


/***/ })

/******/ });