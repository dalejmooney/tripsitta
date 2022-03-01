<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//public
Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('login/facebook', 'Auth\SocialLoginController@redirectToProvider')->name('facebook_login');
Route::get('login/facebook/callback', 'Auth\SocialLoginController@handleProviderCallback')->name('facebook_login_callback');

Route::get('login/google', 'Auth\GoogleSocialLoginController@redirectToProvider')->name('google_login');
Route::get('login/google/callback', 'Auth\GoogleSocialLoginController@handleProviderCallback')->name('google_login_callback');

Route::get('search-holiday-nanny', 'HolidayNannySearchController@index')->name('search-holiday-nanny');
Route::post('search-holiday-nanny', 'HolidayNannySearchController@search');
Route::get('holiday-nanny-list', 'HolidayNannySearchController@showAll')->name('holiday-nanny-show-all');
Route::get('search-local-babysitter', 'BabysitterSearchController@index')->name('search-local-babysitter');
Route::post('search-local-babysitter', 'BabysitterSearchController@search');
Route::get('babysitter-list', 'BabysitterSearchController@showAll')->name('babysitter-show-all');
Route::get('register', 'Auth\RegisterController@index')->name('register');
Route::get('register/{account_type}', 'Auth\RegisterController@show')->name('register-specific'); // validated through binding in RouteServiceProvider
Route::post('register', 'Auth\RegisterController@register');

Route::get('book-babysitter/{babysitter_slug}/{country_town}/{start_datetime}/{end_datetime}', 'BookingController@showBabysitterForm')->name('book-babysitter');
Route::get('book-holiday-nanny/{babysitter_slug}/{start_country}/{end_country}/{start_date}/{end_date}', 'BookingController@showHolidayNannyForm')->name('book-holiday-nanny');
Route::post('book-now', 'BookingController@bookingCreate')->name('book-now');

Route::post('contact-us', 'ContactController@action')->name('contact-us');

// parents only
Route::prefix('parent')->namespace('Parent')->middleware('can:parentOnly')->group(function () {
    Route::get('/overview', 'OverviewController@index')->name('parent.overview');
    Route::get('/bookings', 'BookingController@index')->name('parent.bookings');
    Route::get('/bookings/{booking}', 'BookingController@show')->name('parent.booking')->middleware('can:viewParentBookingDetails,booking');
    Route::post('/bookings/{booking}/update-status', 'BookingStatusController@update')->name('parent.booking-update-status')->middleware(['can:viewParentBookingDetails,booking', 'ajax']);
    Route::get('/invoices/{booking?}/{stripe?}', 'BookingInvoicesController@index')->name('parent.invoices');
    Route::get('/invoice/pay/{invoice_ref}', 'BookingInvoicesController@selectToPay')->name('parent.invoice.pay');
    Route::get('/invoice/{invoice_ref}', 'BookingInvoicesController@show')->name('parent.invoice')->middleware(['can:viewParentInvoice,invoice_ref']);
    Route::get('/my-profile', 'ProfileController@showFormPart1')->name('parent.my-profile');
    Route::post('/my-profile', 'ProfileController@savePart1');
    Route::get('/my-profile/children', 'ProfileController@showFormPart2')->name('parent.my-profile-children');
    Route::post('/my-profile/children', 'ProfileController@savePart2');
    Route::get('/my-profile/address', 'ProfileController@showFormPart3')->name('parent.my-profile-address');
    Route::post('/my-profile/address', 'ProfileController@savePart3');

    Route::get('/bookings-chat/{booking}', 'ChatController@show')->name('parent.booking-chat')->middleware(['can:viewParentBookingDetails,booking']);
    Route::post('/bookings-chat/{booking}', 'ChatController@store')->middleware(['can:viewParentBookingDetails,booking', 'ajax']);

    Route::get('/bookings-review/{booking}', 'BookingReviewController@show')->name('parent.booking-review')->middleware(['can:leaveFeedbackParent,booking']);
    Route::post('/bookings-review/{booking}', 'BookingReviewController@store')->middleware(['can:leaveFeedbackParent,booking', 'ajax']);

    Route::get('/my-profile/submit-application', 'ProfileController@showFormFinal')->name('parent.my-profile-submit-application');
    Route::post('/my-profile/submit-application', 'ProfileController@saveFinal')->middleware('can:doFinalRegistrationForFamily');

    Route::get('/admin-chat', 'ChatController@showAdmin')->name('parent.admin-chat');
    Route::post('/admin-chat', 'ChatController@storeAdmin')->middleware(['ajax']);
});
Route::get('book-now-2', 'BookingController@bookingPaymentForm')->middleware('can:makeBookingPayment')->name('book-now-payment');
Route::post('book-now-2', 'BookingController@saveBabysitterBooking')->middleware(['can:makeBookingPayment', 'ajax']); // ajax

Route::get('book-now-summary/{stripe_session_id}', 'BookingController@showSummaryPage')->middleware('can:seeBookingSummary')->name('book-now-summary');

// babysitters only
Route::prefix('babysitter')->namespace('Babysitter')->middleware('can:babysitterOnly')->group(function () {
    Route::get('/overview', 'OverviewController@index')->name('babysitter.overview');
    Route::get('/bookings', 'BookingController@index')->name('babysitter.bookings');
    Route::get('/bookings/{booking}', 'BookingController@show')->name('babysitter.booking')->middleware('can:viewBabysitterBookingDetails,booking');
    Route::post('/bookings/{booking}/update-status', 'BookingStatusController@update')->name('babysitter.booking-update-status')->middleware(['can:viewBabysitterBookingDetails,booking', 'ajax']);
    Route::get('/invoices/{booking?}', 'BookingInvoicesController@index')->name('babysitter.invoices');
    Route::get('/invoice/{invoice_ref}', 'BookingInvoicesController@show')->name('babysitter.invoice')->middleware(['can:viewBabysitterInvoice,invoice_ref']);
    Route::get('/invoices/create/{booking}', 'BookingInvoicesController@create')->name('babysitter.invoice-create')->middleware('can:viewBabysitterBookingDetails,booking');
    Route::post('/invoices/create/{booking}', 'BookingInvoicesController@store');

    Route::get('/transactions', 'TransactionController@index')->name('babysitter.transactions');
    Route::get('/bank_details', 'BankDetailsController@index')->name('babysitter.bank_details');
    Route::post('/bank_details', 'BankDetailsController@store');

    Route::get('/my-profile', 'ProfileController@showFormPart1')->name('babysitter.my-profile');
    Route::post('/my-profile', 'ProfileController@savePart1');

    Route::get('/my-profile/addresses', 'ProfileController@showFormPart2')->name('babysitter.my-profile-addresses');
    Route::post('/my-profile/addresses', 'ProfileController@savePart2');

    Route::get('/my-profile/about-me', 'ProfileController@showFormPart3')->name('babysitter.my-profile-about-me');
    Route::post('/my-profile/about-me', 'ProfileController@savePart3');

    Route::get('/my-profile/experience', 'ProfileController@showFormPart4')->name('babysitter.my-profile-experience');
    Route::post('/my-profile/experience', 'ProfileController@savePart4');

    Route::get('/my-profile/submit-application', 'ProfileController@showFormPart5')->name('babysitter.my-profile-submit-application');
    Route::post('/my-profile/submit-application', 'ProfileController@savePart5')->middleware('can:doFinalRegistrationForBabysitter');

    Route::get('/my-profile/availability', 'AvailabilityController@show')->name('babysitter.my-profile-availability');
    Route::post('/my-profile/availability', 'AvailabilityController@store');

    Route::get('/bookings-chat/{booking}', 'ChatController@show')->name('babysitter.booking-chat')->middleware(['can:viewBabysitterBookingDetails,booking']);
    Route::post('/bookings-chat/{booking}', 'ChatController@store')->middleware(['can:viewBabysitterBookingDetails,booking', 'ajax']);

    Route::get('/admin-chat', 'ChatController@showAdmin')->name('babysitter.admin-chat');
    Route::post('/admin-chat', 'ChatController@storeAdmin')->middleware(['ajax']);
});

Route::get('babysitter/{slug}', 'BabysitterProfileController@show')->name('babysitter-profile-show');

//files
Route::get('storage/__files/{file_path}/{file_name}', function($file_path, $file_name) {
    return response()->file(storage_path().'/app/public/__files/'.$file_path.'/'.$file_name);
})->middleware('auth:twill_users');

//blog
Route::get('/blog', 'PostsController@index')->name('blog');
Route::get('/blog/{slug?}', 'PostsController@show');

Route::post('/stripe/webhook', 'StripeWebhookController@action')->name('stripe-webhook');

// dynamic pages
Route::get('/{slug?}', 'PagesController@index');
