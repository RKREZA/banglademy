<?php


Route::prefix('bundle-subscription')->group(function () {

    Route::get('/courses', 'BundleSubscriptionController@index')->name('bundle.subscription');

    Route::get('/bundle/course-list', 'BundleSubscriptionController@show')->name('bundle.show');


    Route::group(['middleware' => ['auth', 'admin']], function () {
        Route::get('/bundle/course', 'BundleCoursePlanController@index')->name('bundle.course');
        Route::post('/bundle/store', 'BundleCoursePlanController@store')->name('bundle.store');
        Route::get('/bundle/edit', 'BundleCoursePlanController@edit')->name('bundle.edit');
        Route::post('/bundle/update', 'BundleCoursePlanController@update')->name('bundle.update');
        Route::get('/bundle/delete/{id}', 'BundleCoursePlanController@delete')->name('bundle.delete');

        Route::post('/change/position', 'BundleCoursePlanController@changePosition')->name('change.position');

        Route::post('/change/status', 'BundleCoursePlanController@changeStatus')->name('change.status');

        Route::get('/course/store', 'BundleCourseController@index')->name('course.index');
        Route::post('/course/store', 'BundleCourseController@store')->name('course.store');
        Route::post('/course/delete', 'BundleCourseController@destroy')->name('bundle.course.delete');


        Route::get('/bundle/datatable', 'BundleCoursePlanController@datatable')->name('bundle.datatable');
        Route::get('/setting', 'BundleSubscriptionController@setting')->name('bundle.setting.index');
        Route::post('/setting-store', 'BundleSubscriptionController@settingStore')->name('bundle.setting.store');
    });

    Route::group(['middleware' => ['auth', 'student']], function () {
        Route::get('Bundle/checkout', 'BundleSubscriptionController@BundleCheckOut')->name('bundle.checkOut')->middleware('auth');
        Route::get('Bundle/cart', 'BundleSubscriptionController@Bundlecart')->name('bundle.cart')->middleware('auth');

        Route::get('Bundle/renew', 'BundleSubscriptionController@BundleRenew')->name('bundle.renew')->middleware('auth');

        Route::post('Bundle/review/submit', 'BundleSubscriptionController@BundleReview')->name('submit.bundle.review')->middleware('auth');
        Route::get('bundle/review-delete/{id}', 'BundleSubscriptionController@deleteBundleReview')->name('delete.bundle.review')->middleware('auth');


        Route::get('student-bundle', 'BundleSubscriptionController@dashboard')->name('student.dashboard');
    });

});


Route::get('instructor-setting', 'BundleSubscriptionController@instructor')->name('instructor.change');
Route::post('/instructor/position', 'BundleSubscriptionController@instructorPosition')->name('instructor.position');
