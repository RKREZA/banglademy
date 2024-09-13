<?php

namespace Modules\HumanResource\Http\Controllers;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\HumanResource\Entities\Attendance;
use Modules\HumanResource\Repositories\InstructorAttendanceRepository;
use Modules\RolePermission\Entities\Role;
use PDF;

class InstructorAttendanceController extends Controller
{
    protected $instructorAttendanceRepo;

    public function __construct(InstructorAttendanceRepository $instructorAttendanceRepo)
    {
        $this->instructorAttendanceRepo = $instructorAttendanceRepo;
    }

    public function create(Request $request)
    {
        try{
            $user = Auth::user();
            $data['date'] = isset($request->date) ? $request->date : date('m/d/Y');
            if($user->role_id == 5){
                $data['users'] = User::where('role_id', 2)->where('added_by',$user->id)->get();
            }else{
                $data['users'] = User::where('role_id', 2)->get();
            }
            return view('humanresource::attendance.instructor_attendance.create',$data);
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return  back();

        }

    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $this->instructorAttendanceRepo->create($request->all());
            DB::commit();
            Toastr::success(__('attendance.Instructor Attendance Take Successfully!'));
            return  back();
        }catch(\Exception $e){
            DB::rollBack();
            Toastr::error($e->getMessage(), 'Error!!');
            return  back();

        }
    }
    public function attendance_report_print($year, $month)
    {
        try{
            $user = Auth::user();
            if($user->role_id == 5){
                $users = User::where('role_id',2)->where('added_by',$user->id)->get();
            }else{
                $users = User::where('role_id',2)->get();
            }

            $report_dates = Attendance::where('month', $month)->where('year', $year)->distinct()->get(['date']);
            $role = Role::find(2);
            $m = $month;
            $y = $year;
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $customPaper = array(0, 0, 700.00, 1000.80);
            $pdf = PDF::loadView(
                'humanresource::attendance.attendance_reports.staff_attendance_print',
                [
                    'report_dates' => $report_dates,
                    'users' => $users,
                    'm' => $m,
                    'y' => $y,
                    'role' => $role,
                    'months' => $months,
                    'instructor' => true,
                ]
            )->setPaper('A4', 'landscape');
            return $pdf->stream('instructor_attendance.pdf');

        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

}
