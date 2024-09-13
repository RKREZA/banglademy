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

Route::prefix('humanresource')->group(function() {
    Route::get('/', 'HumanResourceController@index');
});

Route::prefix('hr')->group(function(){
    Route::post('/staff-document/store', 'StaffController@document_store')->name('staff_document.store');
    Route::get('/staff-document/destroy/{id}', 'StaffController@document_destroy')->name('staff_document.destroy');
    Route::get('/profile-view', 'StaffController@profile_view')->name('profile_view');
    Route::post('/profile-edit', 'StaffController@profile_edit')->name('profile_edit_modal');
    Route::post('/profile-update/{id}', 'StaffController@profile_update')->name('profile.update');
    Route::get('settings', 'StaffController@settings')->name('staffs.settings');
    Route::post('settings', 'StaffController@settingsPost')->name('staffs.settings');

    Route::resource('staffs', 'StaffController')->except('destroy')->middleware('RoutePermissionCheck:staffs.index');
    Route::post('/staff-status-update', 'StaffController@status_update')->name('staffs.update_active_status');
    Route::get('/staff/view/{id}', 'StaffController@show')->name('staffs.view');
    Route::get('/staff/report-print/{id}', 'StaffController@report_print')->name('staffs.report_print');
    Route::get('/staff/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy')->middleware('RoutePermissionCheck:staffs.destroy');
    Route::get('/staff/active/{id}', 'StaffController@active')->name('staffs.active');
    Route::get('/staff/inactive/{id}', 'StaffController@inactive')->name('staffs.inactive');
    Route::post('/staff/inactive-update/{id}', 'StaffController@inactiveUpdate')->name('staffs.inactive.update');
    Route::get('/staff/document-upload', 'StaffController@documentUpload')->name('staffs.document.upload');
    Route::post('/staff/document-store', 'StaffController@documentUploadStore')->name('staffs.document.store');
    Route::get('/staff/document-remove/{id}', 'StaffController@documentRemove')->name('staffs.document.remove');
    Route::get('/staff/resume/{id?}', 'StaffController@staffResume')->name('staffs.resume');

    Route::get('/staff/csv-upload-page', 'StaffController@csv_upload')->name('staffs.csv_upload');
    Route::post('/staff/csv-upload-store', 'StaffController@csv_upload_store')->name('staffs.csv_upload_store');

    Route::group(['prefix' => 'staff-payroll'], function(){
        //payroll
        Route::get('payroll', ['as' => 'payroll', 'uses' => 'SmPayrollController@index'])->middleware('RoutePermissionCheck:payroll');

        Route::post('payroll', ['as' => 'payroll', 'uses' => 'SmPayrollController@searchStaffPayr']);

        Route::get('generate-Payroll/{id}/{month}/{year}', 'SmPayrollController@generatePayroll')->name('generate-Payroll');
        Route::post('save-payroll-data', ['as' => 'savePayrollData', 'uses' => 'SmPayrollController@savePayrollData']);

        Route::get('pay-payroll/{id}/{role_id}', 'SmPayrollController@paymentPayroll')->name('pay-payroll');
        Route::post('savePayrollPaymentData', ['as' => 'savePayrollPaymentData', 'uses' => 'SmPayrollController@savePayrollPaymentData']);
        Route::get('view-payslip/{id}', 'SmPayrollController@viewPayslip')->name('view-payslip');
        Route::get('print-payslip/{id}', 'SmPayrollController@printPayslip')->name('print-payslip');

        //payroll Report
        Route::get('payroll-report', 'SmPayrollController@payrollReport')->name('payroll-report')->middleware('RoutePermissionCheck:payroll-report');
        Route::post('search-payroll-report', ['as' => 'searchPayrollReport', 'uses' => 'SmPayrollController@searchPayrollReport']);
        Route::get('search-payroll-report', 'SmPayrollController@searchPayrollReport');
    });
});


Route::prefix('leave')->group(function() {
    Route::get('apply', 'LeaveController@index')->name('apply_leave.index');
    Route::post('/store', 'LeaveController@store')->name('apply_leave.store');
    Route::post('/edit', 'LeaveController@edit')->name('apply_leave.edit');
    Route::get('/carry-forward', 'LeaveController@carryForward')->name('carry.forward')->middleware('RoutePermissionCheck:carry.forward');
    Route::get('/generate-carry-forward', 'LeaveController@generateCarryForward')->name('generate.carry.forward');
    Route::post('{id}/update', 'LeaveController@update')->name('apply_leave.update');
    Route::post('carry-forward/add', 'LeaveController@updateCarryForward')->name('carry.forward.update');
    Route::get('/destroy/{id}', 'LeaveController@destroy')->name('apply_leave.destroy');
    Route::post('/view', 'LeaveController@show')->name('apply_leave.view');
    Route::get('/pending', 'LeaveController@pending_index')->name('pending_index')->middleware('RoutePermissionCheck:pending_index');
    Route::get('/leave-application/download/{id}', 'LeaveController@downloadLeaveApplication')->name('leave.application.download');


    Route::get('/approved', 'LeaveController@approved_index')->name('approved_index')->middleware('RoutePermissionCheck:approved_index');
    Route::get('/approved-leave-department', 'LeaveController@departmentWiseApprove')->name('approve.leave.department');
    Route::get('/approved-leave-department/search', 'LeaveController@departmentWiseSearch')->name('search.leave.department');
    Route::post('/department-wise/staffs', 'LeaveController@staffs')->name('organization.staff');
    Route::post('/change-approval', 'LeaveController@change_approval')->name('set_approval_leave');

    Route::get('/define-lists', 'LeaveDefineController@index')->name('leave_define.index')->middleware('RoutePermissionCheck:leave_define.index');
    Route::post('/define-store', 'LeaveDefineController@store')->name('leave_define.store')->middleware('RoutePermissionCheck:leave_define.index');
    Route::post('/define-update', 'LeaveDefineController@update')->name('leave_define.update')->middleware('RoutePermissionCheck:leave_define.index');
    Route::post('/define-delete', 'LeaveDefineController@delete')->name('leave_define.delete')->middleware('RoutePermissionCheck:leave_define.index');

    Route::get('/types', 'LeaveTypeController@index')->name('leave_types.index')->middleware('RoutePermissionCheck:leave_types.index');
    Route::post('/types-store', 'LeaveTypeController@store')->name('leave_types.store')->middleware('RoutePermissionCheck:leave_types.index');
    Route::post('/types-update', 'LeaveTypeController@update')->name('leave_types.update')->middleware('RoutePermissionCheck:leave_types.index');
    Route::post('/types-delete', 'LeaveTypeController@delete')->name('leave_types.delete')->middleware('RoutePermissionCheck:leave_types.index');

    Route::get('/hr/departments', 'DepartmentController@index')->name('hr.department.index');
    Route::post('/hr/departments/store', 'DepartmentController@store')->name('hr.department.store');
    Route::post('/hr/departments/update', 'DepartmentController@update')->name('hr.department.update');
    Route::post('/hr/departments/delete', 'DepartmentController@delete')->name('hr.department.delete');

    Route::resource('holidays', 'HolidayController');
    Route::post('/add-row', 'HolidayController@addRow')->name('add.row');
    Route::post('/holidays/add', 'HolidayController@holidayAdd')->name('holiday.add');
    Route::get('/holidays/delete/{year}', 'HolidayController@holidayDelete')->name('holiday.delete');
    Route::post('/last-year-data', 'HolidayController@getLastYearData')->name('last.year.data');
    Route::get('/holidays/edit/{id}', 'HolidayController@yearData')->name('year.data');
    Route::get('/holidays/view/details/{id}', 'HolidayController@viewYearData')->name('view.year.data');
});

Route::prefix('attendance')->middleware('auth')->group(function () {

    Route::prefix('hr')->group(function () {
        Route::group(['prefix' => '/attendance'], function () {
            Route::get('/', 'AttendanceController@index')->name('attendances.index')->middleware('RoutePermissionCheck:attendances.index');
            Route::post('/store', 'AttendanceController@store')->name('attendances.store')->middleware('RoutePermissionCheck:attendances.index');
            // Attendance Report Controller
//            Route::get('/report-index', 'AttendanceReportController@index')->name('attendance_report.index')->middleware('attendance_report.index');
            Route::get('/report-index', 'AttendanceReportController@index')->name('attendance_report.index')->middleware('RoutePermissionCheck:attendance_report.index');
        });
    });
    //instructor attendance
    Route::resource('instructor_attendance', 'InstructorAttendanceController')->only(['create','store'])->middleware('RoutePermissionCheck:instructor_attendance.create');
    Route::get('/instructor-attendance-report-print/{year}/{month}', 'InstructorAttendanceController@attendance_report_print')->name('instructor_attendance.report.print');

    Route::resource('holidays', 'HolidayController');
    Route::post('/add-row', 'HolidayCOntroller@addRow')->name('add.row');
    Route::get('/last-year-data', 'HolidayController@getLastYearData')->name('last.year.data');

    Route::prefix('attendance')->group(function () {
        Route::post('/get-user-by-role', 'AttendanceController@get_user_by_role')->name('get_user_by_role');
        Route::get('/report-index/search', 'AttendanceReportController@reports')->name('attendance_report.search');
        Route::get('/attendence-report-print/{role_id}/{month}/{year}', 'AttendanceReportController@attendance_report_print')->name('attendance_report_print');
    });

});

Route::group(['middleware' => 'auth'], function (){
    Route::resource('to_dos','ToDoController');
    Route::get('complete-to-do','ToDoController@completeToDo');
    Route::get('get-to-do-list','ToDoController@completeList');
    Route::resource('events','EventController');
    Route::get('events-delete/{id}','EventController@destroy')->name('events.delete');
});

Route::post('/role-user','AttendanceController@roleUsers')->name('get.role.users');

Route::prefix('payroll')->group(function() {

    Route::get('/', 'PayrollController@index')->name('payroll.index')->middleware('permission');
    Route::get('/staff-list-for-payroll', 'PayrollController@search_for_payroll')->name('staff_search_for_payroll');
    Route::get('/pdf/{id}', 'PayrollController@getPdf')->name('payroll.pdf');
    Route::get('/generate-Payroll/{id}/{month}/{year}', 'PayrollController@generatePayroll');
    Route::post('/save-payroll-data', 'PayrollController@savePayrollData')->name('save_payroll');
    Route::post('/payment/modal', 'PayrollController@paymentPayroll')->name('payroll_payment_modal');
    Route::post('/payment-slip/modal', 'PayrollController@viewPayslip')->name('payroll_view_slip_modal');
    Route::post('/savePayrollPaymentData', 'PayrollController@savePayrollPaymentData')->name('payroll_payment_store');


    // Payroll Report
    Route::get('/reports', 'PayrollController@report_index')->name('payroll_reports.index')->middleware('permission');
    Route::get('/reports/search', 'PayrollController@searchPayrollReport')->name('payroll_reports.search');
});
