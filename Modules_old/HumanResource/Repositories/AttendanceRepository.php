<?php

namespace Modules\HumanResource\Repositories;

use App\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\HumanResource\Entities\Holiday;
use Modules\Setting\Model\GeneralSetting;
use Modules\HumanResource\Entities\Attendance;

class AttendanceRepository implements AttendanceRepositoryInterface
{


    public function create(array $data)
    {
        $total_today_attendace = Attendance::where('date', Carbon::parse($data['date']))->count();
        $update_user_attendance = count($data['user']);
        $day = new DateTime($data['date']);
        if ($total_today_attendace < $update_user_attendance) {
            foreach ($data['user'] as $key => $user_id) {
                $user_exist = Attendance::where('user_id', $user_id)
                    ->where('course_id', $data['course_id'])
                    ->where('date', Carbon::parse($data['date']))
                    ->first();


                if ($user_exist == null) {
                    $attendance_user = new Attendance;
                    $attendance_user->user_id = $user_id;
                    $attendance_user->date = Carbon::parse($data['date']);
                    $attendance_user->day = $day->format('l');
                    $attendance_user->month = $day->format('F');
                    $attendance_user->year = now()->year;
                    $attendance_user->course_id = $data['course_id'];
                    $attendance_user->save();
                }
            }
        }
        foreach ($data['attendance'] as $key => $value) {
            $role = User::find($key)->role_id;
            $attendance = Attendance::where('user_id', $key)
                ->where('course_id', $data['course_id'])
                ->where('date', Carbon::parse($data['date']))
                ->first();
            $attendance->user_id = $key;
            $attendance->course_id = $data['course_id'];
            $attendance->role_id = $role;
            $attendance->entering_time = $data['entering_time'][$key];
            $attendance->leaving_time = $data['leaving_time'][$key];
            $attendance->attendance = $this->calculateAttendancePercentage($data['entering_time'][$key],$data['leaving_time'][$key],$data['meeting_duration'],$value);
            $attendance->note = $data['note_' . $key];
            $attendance->save();
        }
    }

    public function calculateAttendancePercentage($entering_time,$leaving_time,$meeting_duration,$attendance_type)
    {
        // dd($entering_time);
        $meeting_duration=$meeting_duration;
        $system_percentage=$setting = GeneralSetting::first()->class_min_percentage;

        $to_time = strtotime($entering_time);
        $from_time = strtotime($leaving_time);
        $minutes = round(abs($to_time - $from_time) / 60,2);

        $std_done_class=($minutes*100)/$meeting_duration;
        $std_done_class=number_format((float)$std_done_class,2,'.','');
        if ($system_percentage > $std_done_class) {
           return 'A';
        } else {
           return $attendance_type;
        }


    }
    public function get_user_by_role($id)
    {
        return User::where('role_id', $id)->get();
    }

    public function report(array $data)
    {
       $instructor = isset($data['instructor'])?true :false;
       if(!$instructor){
           return Attendance::where('course_id', $data['course_id'])->where('month', $data['month'])->where('year', $data['year'])->get();
       }else{
           return Attendance::where('role_id', 2)->where('month', $data['month'])->where('year', $data['year'])->get();
       }
    }

    public function date(array $data)
    {
        return Attendance::where('month', $data['month'])->where('year', $data['year'])->distinct()->get(['date']);
    }

    public function user(array $data)
    {
        return User::where('role_id', $data['role_id'])->get();
    }

    public function attendanceByDate($date,$type)
    {
        if ($type == 0)
            return Attendance::whereDate('date',$date)->delete();
        else
        {
            $date_range = explode(',',$date);
            $start_date = $date_range[0];
            $end_date = $date_range[1];
            return Attendance::whereBetween('date',[$start_date,$end_date])->delete();
        }

    }
}
