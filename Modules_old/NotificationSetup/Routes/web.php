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

Route::prefix('notification-setup')->middleware(['auth'])->group(function() {
    Route::get('/', 'NotificationSetupController@index')->name('notification_setup_list')->middleware('RoutePermissionCheck:notification_setup_list');
    Route::post('/', 'NotificationSetupController@setup')->name('update_notification_setup');
    Route::post('/browser-message', 'NotificationSetupController@UpdateBrowserMsg')->name('updateBrowserMessage')->middleware('RoutePermissionCheck:updateBrowserMessage');
    Route::get('/users-notifications', 'NotificationSetupController@UserNotificationControll')->name('UserNotificationControll')->middleware('RoutePermissionCheck:UserNotificationControll');
    Route::post('/users-notifications', 'NotificationSetupController@UpdateUserNotificationControll')->name('UpdateUserNotificationControll')->middleware('RoutePermissionCheck:UpdateUserNotificationControll');


    Route::get('/my-notifications', 'NotificationSetupController@MyNotification')->name('MyNotification');
});
