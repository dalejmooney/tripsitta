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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/book-now-payment-hn.js":
/*!***************************************************!*\
  !*** ./resources/js/pages/book-now-payment-hn.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $("form[name=book-now-payment]")[0].reset();
  $('input[name=accommodation_booked]').on('change', function () {
    $('#toggle_accommodation_details').addClass('is-hidden');

    if ($('input[name=accommodation_booked]:checked').val() === '1') {
      $('#toggle_accommodation_details').removeClass('is-hidden');
    }
  });
  $('input[name=babysitter_meet]').on('change', function () {
    $('#toggle_babysitter_meet').addClass('is-hidden');

    if ($('input[name=babysitter_meet]:checked').val() === '1') {
      $('#toggle_babysitter_meet').removeClass('is-hidden');
    }
  });
  $('input[name=travel_trip]').on('change', function () {
    $('#toggle_travel_trip').addClass('is-hidden');

    if ($('input[name=travel_trip]:checked').val() === '1') {
      $('#toggle_travel_trip').removeClass('is-hidden');
    }
  });
  $('#continue_booking').on('click', function (e) {
    e.preventDefault();
    $("form[name=book-now-payment]").submit();
  });
  $("form[name=book-now-payment]").validate({
    ignore: [],
    rules: {
      "travel_trip": {
        required: true
      },
      "travel_trip_details": {
        required: function required() {
          return $('input[name=travel_trip]:checked').val() === '1';
        }
      },
      "babysitter_meet": {
        required: true
      },
      "babysitter_meet_details": {
        required: function required() {
          return $('input[name=babysitter_meet]:checked').val() === '1';
        }
      },
      "accommodation_booked": {
        required: true
      },
      "accommodation_details": {
        required: function required() {
          return $('input[name=accommodation_booked]:checked').val() === '1';
        }
      },
      "primary_number_available": {
        required: true
      },
      "emergency_phone_number_available": {
        required: true
      },
      "additional_phone_number": {
        required: function required() {
          return $('input[name=primary_number_available]:checked').val() === '0' && $('input[name=emergency_phone_number_available]:checked').val() === '0';
        }
      },
      "parent_during_booking": {
        required: true
      },
      "booking_notes": {
        required: true
      }
    },
    submitHandler: function submitHandler(form) {
      $('#continue_booking').attr('disabled', 'disabled').addClass('is-loading');
      $('html,body').css("cursor", "progress");
      $.ajax({
        url: "book-now-2",
        type: "post",
        data: $("form[name=book-now-payment]").serialize()
      }).done(function () {
        $('#errors-container').empty().addClass('is-hidden');
        stripe.redirectToCheckout({
          sessionId: CHECKOUT_SESSION_ID
        }).then(function (result) {
          $('#errors-container').html(result.error.message).removeClass('is-hidden');
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
        $('#continue_booking').attr('disabled', false).removeClass('is-loading');
        $('html,body').css("cursor", "default");
      });
    },
    highlight: function highlight(element, errorClass, validClass) {
      if ($(element).is(':radio')) {
        $(element).parent().parent().find('.radio').addClass('has-text-danger').removeClass(validClass);
      } else if ($(element).attr('type') === 'hidden') {
        $(element).parent().addClass('is-danger').removeClass(validClass);
      } else {
        $(element).addClass(errorClass).removeClass(validClass);
      }
    },
    unhighlight: function unhighlight(element, errorClass, validClass) {
      if ($(element).is(':radio')) {
        $(element).parent().parent().find('.radio').removeClass('has-text-danger').addClass(validClass);
      } else if ($(element).attr('type') === 'hidden') {
        $(element).parent().removeClass('is-danger').addClass(validClass);
      } else {
        $(element).removeClass(errorClass).addClass(validClass);
      }
    },
    errorClass: 'is-danger',
    errorElement: 'p',
    errorPlacement: function errorPlacement(error, element) {},
    focusInvalid: false,
    invalidHandler: function invalidHandler(form, validator) {
      if (!validator.numberOfInvalids()) return;
      $('html, body').animate({
        scrollTop: $(validator.errorList[0].element).offset().top - 80
      }, 1000);
      $(validator.errorList[0].element).focus();
    }
  });
});

/***/ }),

/***/ 6:
/*!*********************************************************!*\
  !*** multi ./resources/js/pages/book-now-payment-hn.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\laragon\www\tripsitta\tripsitta\resources\js\pages\book-now-payment-hn.js */"./resources/js/pages/book-now-payment-hn.js");


/***/ })

/******/ });