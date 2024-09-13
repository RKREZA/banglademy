<?php

Route::prefix('bkash')->middleware(['student'])->group(function () {
    // Payment Routes for bKash
    Route::post('/get-token', 'BkashController@getToken')->name('bkash-get-token');
    Route::post('/create-payment', 'BkashController@createPayment')->name('bkash-create-payment');
    Route::post('/execute-payment', 'BkashController@executePayment')->name('bkash-execute-payment');
    Route::get('/query-payment', 'BkashController@queryPayment')->name('bkash-query-payment');
    Route::post('/success/{type}', 'BkashController@bkashSuccess')->name('bkash-success');

});
