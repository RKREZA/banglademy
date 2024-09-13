<?php


Route::prefix('course-offer')->group(function () {
    Route::get('/', 'CourseOfferController@index')->name('courseOffer');
    Route::post('/', 'CourseOfferController@store');
    Route::post('add-course', 'CourseOfferController@addOfferCourse')->name('addOfferCourse');
    Route::post('remove-course', 'CourseOfferController@removeOfferCourse')->name('removeOfferCourse');
});
