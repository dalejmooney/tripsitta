<?php

// Register Twill routes here (eg. Route::module('posts'))
Route::group(['prefix' => 'cms'], function () {
    Route::module('pages');
    Route::module('posts');
    Route::module('slideshows');
});

Route::group(['prefix' => 'b'], function () {
    Route::module('babysitters');
    Route::module('babysitterReviews');
    Route::get('/interviews', 'InterviewsCalendar@index')->name('b.interviews-calendar');
    Route::post('/interviews', 'InterviewsCalendar@store');
    Route::get('babysitterPayouts/transferwise', 'BabysitterPayoutController@getTransferwiseProfiles')->name('b.payout.transferwise');
    Route::module('babysitterPayouts');
    Route::get('babysitterPayouts/{payout}/pay', 'BabysitterPayoutController@processPayout')->name('payout.pay');
    Route::module('invoices'); // duplicate - should be removed from here
});

Route::module('babysitters', [], ['only' => ['browse','edit']]); // duplicate - should be removed from here
Route::module('families');
Route::module('bookings');
Route::module('invoices');
Route::get('invoice/{invoice}/{type?}', 'InvoiceController@showInvoice')->name('invoice.showInvoice');


Route::module('chats');
