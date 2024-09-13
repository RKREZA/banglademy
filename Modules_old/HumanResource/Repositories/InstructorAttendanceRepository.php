<?php

namespace Modules\HumanResource\Repositories;

use Modules\HumanResource\Entities\Attendance;
use Carbon\Carbon;
use DateTime;
use App\User;



class InstructorAttendanceRepository
{


    public function create(array $data)
    {
        $total_today_attendace = Attendance::where('date', Carbon::parse($data['date']))->where('role_id',2)->count();
        $update_user_attendance = count($data['user']);
        $day = new DateTime($data['date']);
        if ($total_today_attendace < $update_user_attendance) {
            foreach ($data['user'] as $key => $user_id) {
                $user_exist = Attendance::where('user_id', $user_id)->where('date', Carbon::parse($data['date']))->first();
                if ($user_exist == null) {
                    $attendance_user = new Attendance;
                    $attendance_user->user_id = $user_id;
                    $attendance_user->date = Carbon::parse($data['date']);
                    $attendance_user->day = $day->format('l');
                    $attendance_user->month = $day->format('F');
                    $attendance_user->year = now()->year;
                    $attendance_user->save();
                }
            }
        }
        foreach ($data['attendance'] as $key => $value) {

            $role = User::find($key)->role_id;
            $attendance = Attendance::where('user_id', $key)
                ->where('date', Carbon::parse($data['date']))
                ->first();
            $attendance->user_id = $key;
            $attendance->role_id = $role;
            $attendance->attendance = $value;
            $attendance->note = $data['note_' . $key];
            $attendance->late_note = $value == 'L' ? $data['late_note_' . $key]:NULL;
            $attendance->save();
        }
        return true;
    }
}
