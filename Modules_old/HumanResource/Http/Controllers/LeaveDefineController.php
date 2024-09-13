<?php

namespace Modules\HumanResource\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HumanResource\Repositories\LeaveDefineRepository;
use Modules\HumanResource\Repositories\LeaveDefineRepositoryInterface;
use Modules\HumanResource\Repositories\LeaveTypeRepository;
use Modules\HumanResource\Repositories\LeaveTypeRepositoryInterface;
use Modules\RolePermission\Entities\Role;
use Modules\RolePermission\Repositories\RoleRepository;
use Modules\RolePermission\Repositories\RoleRepositoryInterface;
use Modules\UserActivityLog\Traits\LogActivity;

class LeaveDefineController extends Controller
{
    private $leaveDefineRepository,$roleRepo,$leaveTypeRpo;

    public function __construct(LeaveDefineRepository $leaveDefineRepository,RoleRepository $roleRepo,LeaveTypeRepository $leaveTypeRpo)
    {
        $this->leaveDefineRepository = $leaveDefineRepository;
        $this->roleRepo = $roleRepo;
        $this->leaveTypeRpo = $leaveTypeRpo;
    }

    public function index()
    {
        try {
            $data['LeaveDefineList'] = $this->leaveDefineRepository->all();
            $data['RoleList'] = Role::all();
            $data['LeaveTypeList'] = $this->leaveTypeRpo->all();

            return view('humanresource::leave.leave_defines.index', $data);

        } catch (\Exception $e) {
            Toastr::error('Operation failed');
            return back();
        }
    }

    public function store(Request $request)
    {
        $validate_rules = [
            'role_id' => 'required',
            'leave_type_id' => 'required',
            'total_days' => 'required',
            'max_forward' => 'required_if:balance_forward,==,1',
        ];
        $request->validate($validate_rules, validationMessage($validate_rules));

        try {
            DB::beginTransaction();
            $defined = $this->leaveDefineRepository->roleWiseLeave($request->leave_type_id,$request->role_id);
            $request['adjust_days'] = $defined ? $defined->total_days : 0;

            if ($defined && empty($request->users))
            {
                return response()->json("leave.Leave Type For this role already defined");
            }

            $this->leaveDefineRepository->create($request->all());
            $LeaveDefineList = $this->leaveDefineRepository->all();
            DB::commit();

            return response()->json([
                'success' => trans('common.Operation successful'),
                'TableData' => (string)view('humanresource::leave.leave_defines.components.list', compact('LeaveDefineList'))
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $validate_rules = [
            'role_id' => 'required',
            'leave_type_id' => 'required',
            'total_days' => 'required',
            'max_forward' => 'required_if:balance_forward,==,1',
        ];
        $request->validate($validate_rules, validationMessage($validate_rules) );
        DB::beginTransaction();
        try {

            $this->leaveDefineRepository->update($request->all(), $request->id);

            $LeaveDefineList = $this->leaveDefineRepository->all();
            DB::commit();

            return response()->json([
                'success' => trans('common.Operation successful'),
                'TableData' => (string)view('humanresource::leave.leave_defines.components.list', compact('LeaveDefineList'))
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(trans('common.Something Went Wrong'));
        }
    }

    public function delete(Request $request)
    {
        $validate_rules = [
            'id' => 'required',
        ];
        $request->validate($validate_rules, validationMessage($validate_rules));

        try {
            $this->leaveDefineRepository->delete($request->id);
            $LeaveDefineList = $this->leaveDefineRepository->all();

            return response()->json([
                'success' => trans('common.Operation successful'),
                'TableData' => (string)view('humanresource::leave.leave_defines.components.list', compact('LeaveDefineList'))
            ]);

        } catch (\Exception $e) {
            return response()->json(trans('common.Something Went Wrong'));
        }
    }
}
