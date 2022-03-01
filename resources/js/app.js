window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('jquery-validation');
require('jquery-validation/dist/additional-methods');
moment = require('moment');
require('jquery-mask-plugin');

$(document).ready(function(){
    $('.navbar-burger').on('click', function (e) {
        e.preventDefault();

        $('#navbar-primary').toggleClass('is-active');
    });

    $('.navbar-item.has-dropdown').on('click', '.navbar-link', function (e) {
        e.preventDefault();

        $(this).siblings('.navbar-dropdown').toggle();
    });
});


$.validator.addMethod("dobRange", function (value, element) {
    let min = moment().subtract(18, 'years');
    let max = moment();
    let inputDate = moment(value, "DD/MM/YYYY");
    if(inputDate < min || inputDate > max)
        return false;
    return true;
}, "Our babysitters can only care for children 18 years old and under");
