<?php

namespace Modules\HumanResource\Http\Controllers;

use App\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\HumanResource\Entities\Holiday;
use Modules\HumanResource\Repositories\AttendanceRepository;
use Modules\Setting\Model\GeneralSetting;
use Modules\CourseSetting\Entities\Course;
use Illuminate\Contracts\Support\Renderable;
use Modules\HumanResource\Http\Requests\AttendanceFormRequest;
use Modules\HumanResource\Repositories\AttendanceRepositoryInterface;

class AttendanceController extends Controller
{
    protected $attaendanceRepository;

    public function __construct(AttendanceRepository $attaendanceRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->attaendanceRepository = $attaendanceRepository;
    }

    public function index()
    {
        return view('humanresource::attendance.attendances.index');
    }

    public function create()
    {
        return view('humanresource::attendance.create');
    }

    public function store(AttendanceFormRequest $request)
    {
        try {
            $this->attaendanceRepository->create($request->except("_token"));
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('attendances.index');
        } catch (\Exception $e) {
            return back()->with('message-danger', __('common.Something Went Wrong'));
        }
    }

    public function show($id)
    {
        return view('humanresource::attendance.show');
    }

    public function edit($id)
    {
        return view('humanresource::attendance.edit');
    }

    public function get_user_by_role(Request $request)
    {
        try {
            $users = Course::find($request->course_id);
            $virtual_classe=$users->class;
            if ($virtual_classe->host=='Zoom') {
                $today_class_info=$virtual_classe->zoomMeetings->where('class_id',$virtual_classe->id)->where('date_of_meeting',$request->date)->first();
            }
            if ($virtual_classe->host=='BBB') {
                $today_class_info=$virtual_classe->bbbMeetings->where('class_id',$virtual_classe->id)->where('date_of_meeting',$request->date)->first();
            }
            if ($virtual_classe->host=='Jitsi') {
                $today_class_info=$virtual_classe->jitsiMeetings->where('class_id',$virtual_classe->id)->where('date_of_meeting',$request->date)->first();
            }
            return view('humanresource::attendance.attendances.create_attendance',[
                'users' => $users->enrollUsers,
                'date' => $request->date,
                'course_id' => $request->course_id,
                'course_info' =>$users,
                'today_class_info' =>$today_class_info,
            ]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function roleUsers(Request $request)
    {
        $users = User::where('role_id', $request->role_id)->where('is_active',1)->get();

        if (count($users) > 0)
        {
            $output ='<option value="">'.trans('common.Select One').'</option>';
            foreach ($users as $user)
            {
                $output .= '<option value="'.$user->id.'">'.$user->name.'</option>';
            }
        }
        else
            $output = '<option>'.trans('common.No data Found').'</option>';

        return $output;
    }
}
