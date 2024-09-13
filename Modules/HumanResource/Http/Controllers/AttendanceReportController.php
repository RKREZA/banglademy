<?php

namespace Modules\HumanResource\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\Attendance;
use Modules\CourseSetting\Entities\Course;
use Modules\RolePermission\Entities\Role;
use Brian2694\Toastr\Facades\Toastr;
use Modules\HumanResource\Http\Requests\AttendanceReportFormRequest;
use Modules\HumanResource\Repositories\AttendanceRepository;
use App\User;
use PDF;

class AttendanceReportController extends Controller
{
    protected $attaendanceRepository;

    public function __construct(AttendanceRepository $attaendanceRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->attaendanceRepository = $attaendanceRepository;
    }
    public function index()
    {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return view('humanresource::attendance.attendance_reports.index', compact('months'));
    }

    public function reports(AttendanceReportFormRequest $request)
    {

        try {
            $user = Auth::user();
            $reports = $this->attaendanceRepository->report($request->all());
            $instructor = isset($request->instructor)?true:false;
            if($instructor){
                if($user->role_id == 5){
                    $users = User::where('role_id',2)->where('added_by',$user->id)->get();
                }else{
                    $users = User::where('role_id',2)->get();
                }

            }else{
                $users = Course::find($request->course_id)->enrollUsers;
            }
            $report_dates = $this->attaendanceRepository->date($request->all());
            $r = $request->course_id;
            $m = $request->month;
            $y = $request->year;
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            return view('humanresource::attendance.attendance_reports.index',[
                'reports' => $reports,
                'report_dates' => $report_dates,
                'users' => $users,
                'r' => $r,
                'm' => $m,
                'y' => $y,
                'months' => $months,
                'instructor' => $instructor
            ]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function attendance_report_print($course_id, $month, $year)
    {
        try{
            $course = Course::with('enrollUsers')->find($course_id);
            $users = $course->enrollUsers;
            $report_dates = Attendance::where('month', $month)->where('year', $year)->distinct()->get(['date']);;
            $role = Role::find(3);
            $r = $course_id;
            $m = $month;
            $y = $year;
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $customPaper = array(0, 0, 700.00, 1000.80);
            $pdf = PDF::loadView(
                'humanresource::attendance.attendance_reports.staff_attendance_print',
                [
                    'report_dates' => $report_dates,
                    'users' => $users,
                    'r' => $r,
                    'm' => $m,
                    'y' => $y,
                    'role' => $role,
                    'course' => $course,
                    'months' => $months
                ]
            )->setPaper('A4', 'landscape');
            return $pdf->stream('staff_attendance.pdf');

        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
