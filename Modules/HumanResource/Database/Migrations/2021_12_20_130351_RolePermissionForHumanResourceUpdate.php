<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolePermissionForHumanResourceUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['id' => 412, 'module_id' => 412, 'parent_id' => null, 'name' =>'Human Resource', 'route' => 'human_resource', 'type' => 1],

            //Staff
            ['id' => 413, 'module_id' => 412, 'parent_id' => 412, 'name' =>'Staff', 'route' => 'staffs.index', 'type' => 2],
            ['id' => 414, 'module_id' => 412, 'parent_id' => 413, 'name' =>'Create', 'route' => 'staffs.store', 'type' => 3],
            ['id' => 415, 'module_id' => 412, 'parent_id' => 413, 'name' =>'Update', 'route' => 'staffs.update', 'type' => 3],
            ['id' => 416, 'module_id' => 412, 'parent_id' => 413, 'name' =>'Delete', 'route' => 'staffs.destroy', 'type' => 3],
            ['id' => 417, 'module_id' => 412, 'parent_id' => 413, 'name' =>'View', 'route' => 'staffs.view', 'type' => 3],
            ['id' => 418, 'module_id' => 412, 'parent_id' => 413, 'name' =>'Active', 'route' => 'staffs.active', 'type' => 3],
            ['id' => 419, 'module_id' => 412, 'parent_id' => 413, 'name' =>'Inactive', 'route' => 'staffs.inactive', 'type' => 3],
            ['id' => 420, 'module_id' => 412, 'parent_id' => 413, 'name' =>'Resume', 'route' => 'staffs.resume', 'type' => 3],

            ['id' => 421, 'module_id' => 412, 'parent_id' => 412, 'name' =>'Department', 'route' => 'hr.department.index', 'type' => 2],
            ['id' => 422, 'module_id' => 412, 'parent_id' => 421, 'name' =>'Store', 'route' => 'hr.department.index', 'type' => 3],

            ['id' => 423, 'module_id' => 412, 'parent_id' => 412, 'name' =>'Attendance', 'route' => 'attendances.index', 'type' => 2],
            ['id' => 424, 'module_id' => 412, 'parent_id' => 412, 'name' =>'Instructor Attendance', 'route' => 'instructor_attendance.create', 'type' => 2],
            ['id' => 425, 'module_id' => 412, 'parent_id' => 412, 'name' =>'Attendance Report', 'route' => 'attendance_report.index', 'type' => 2],


            ['id' => 426, 'module_id' => 426, 'parent_id' => null, 'name' =>'Leave', 'route' => 'apply_leave.index', 'type' => 1],

            ['id' => 427, 'module_id' => 426, 'parent_id' => 426, 'name' =>'Leave Define', 'route' => 'leave_types.index', 'type' => 2],
            ['id' => 428, 'module_id' => 426, 'parent_id' => 426, 'name' =>'Leave Apply', 'route' => 'apply_leave.index', 'type' => 2],
            ['id' => 429, 'module_id' => 426, 'parent_id' => 426, 'name' =>'Approve Leave Request', 'route' => 'approved_index', 'type' => 2],
            ['id' => 430, 'module_id' => 426, 'parent_id' => 426, 'name' =>'Pending Leave', 'route' => 'pending_index', 'type' => 2],
            ['id' => 432, 'module_id' => 426, 'parent_id' => 426, 'name' =>'Holy day Setup', 'route' => 'holidays.index', 'type' => 2],
            ['id' => 433, 'module_id' => 426, 'parent_id' => 426, 'name' =>'Carry Forward', 'route' => 'carry.forward', 'type' => 2],
            ['id' => 434, 'module_id' => 426, 'parent_id' => 426, 'name' =>'Leave Type', 'route' => 'leave_types.index', 'type' => 2],


        ];
        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
