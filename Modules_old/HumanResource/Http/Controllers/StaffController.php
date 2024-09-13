<?php

namespace Modules\HumanResource\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Modules\HumanResource\Entities\Staff;
use App\Traits\FileStore;
use App\Traits\ImageStore;
use App\Traits\Notification;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\HumanResource\Entities\StaffDocument;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Modules\HumanResource\Repositories\LeaveRepository;
use Modules\Payroll\Repositories\PayrollRepositoryInterface;
use Modules\Payroll\Repositories\ApplyLoanRepositoryInterface;
use Modules\HumanResource\Http\Requests\StaffRequest;
use Modules\HumanResource\Http\Requests\StaffUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\RolePermission\Entities\Role;

class StaffController extends Controller
{
//    use Notification;
    use ImageStore;

    protected $userRepository, $leaveRepository, $payrollRepository, $applyLoanRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        LeaveRepository $leaveRepository
//        PayrollRepositoryInterface $payrollRepository
    )
    {
        $this->middleware(['auth', 'verified']);
//        $this->middleware('prohibited.demo.mode')->only(['update', 'profile_update']);

        $this->userRepository = $userRepository;
        $this->leaveRepository = $leaveRepository;
//        $this->payrollRepository = $payrollRepository;
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            if($user->role_id == 5){
                $staffs = Staff::where('created_by',$user->id)->get();
            }else{
                $staffs = Staff::all();
            }

            return view('humanresource::staffs.index', [
                "staffs" => $staffs,
            ]);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }

    }

    public function create()
    {
        return view('humanresource::staffs.create');
    }

    public function store(StaffRequest $request)
    {

        DB::beginTransaction();
        try {
            if ($request->password) {
                try {
                    $data = $request->except("_token");
                    $user = new User();
                    $user->name = $data['name'];
                    $user->email = $data['email'];
                    $user->username = $data['username'];
                    $user->role_id = $data['role_id'] ?? 4;
                    $user->country = $data['country'] ?? null;
                    if (isset($data['photo'])) {
                        $data = Arr::add($data, 'avatar', $this->saveAvatar($data['photo']));
                        $user->image = $data['avatar'];
                    }
                    $user->password = Hash::make($data['password']);
                    $user->email_verified_at = now();
                    $user->save();

                    $staff = new Staff;
                    $staff->user_id = $user->id;
                    $staff->department_id = $data['department_id'];
                    $staff->phone = $data['username'] ?? null;
                    $staff->opening_balance = $data['opening_balance'];
                    $staff->bank_name = $data['bank_name'];
                    $staff->bank_branch_name = $data['bank_branch_name'];
                    $staff->bank_account_name = $data['bank_account_name'];
                    $staff->bank_account_no = $data['bank_account_no'];
                    $staff->basic_salary = $data['basic_salary'] ?? 0 ;
                    $staff->employment_type = $data['employment_type']?? 'Permanent';
                    $staff->date_of_joining = isset($data['date_of_joining']) ? Carbon::parse($data['date_of_joining'])->format('Y-m-d') : date('Y-m-d');
                    if (!empty($data['provisional_months'])) {
                        $staff->provisional_months = $data['provisional_months'];
                    }
                    $staff->date_of_birth = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
                    $staff->leave_applicable_date = Carbon::parse($data['leave_applicable_date'])->format('Y-m-d');
                    $staff->current_address = $data['current_address'];
                    $staff->permanent_address = $data['permanent_address'];
//                    $staff->created_by = Auth::id();
                    $staff->save();

                    DB::commit();
                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));                    return redirect()->route('staffs.index');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Toastr::error($e->getMessage(). $e->getLine().$e->getFile());
                    return back();
                }
            } else {
                DB::rollBack();
                Toastr::error(__('common.Something Went Wrong'));
                return back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('common.Something Went Wrong'));
            return redocument_storedirect()->back();
        }
    }

    public function show(Request $request)
    {
        try {
            $staffDetails = $this->userRepository->find($request->id);
            $leaveDetails = $this->leaveRepository->user_leave_history($staffDetails->user->id);
            $total_leave = $this->leaveRepository->total_leave($staffDetails->user->id);
            $apply_leave_histories = $this->leaveRepository->user_leave_history($staffDetails->user->id);
//            $payrollDetails = $this->payrollRepository->userPayrollDetails($request->id);
//            $loans = $this->applyLoanRepository->staffLoans($staffDetails->user->id);
            $staffDocuments = $this->userRepository->findDocument($request->id);
            $payrollDetails = collect();
            $loans = collect();
            return view('humanresource::staffs.viewStaff', [
                "staffDetails" => $staffDetails,
                "leaveDetails" => $leaveDetails,
                "total_leave" => $total_leave,
                "staffDocuments" => $staffDocuments,
                "payrollDetails" => $payrollDetails,
                'apply_leave_histories' => $apply_leave_histories,
                "loans" => $loans
            ]);
        } catch (\Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));
            return back();
        }
    }

    public function report_print(Request $request)
    {
        try {
            $staffDetails = $this->userRepository->find($request->id);
            return view('humanresource::staffs.print_view', [
                "staffDetails" => $staffDetails,
            ]);
        } catch (\Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));
            return back();
        }
    }

    public function edit($id)
    {
        try {
            $staff = $this->userRepository->find($id);
            $roles = Role::where('type', '!=', 'normal_user')->get()->except(1);
            return view('humanresource::staffs.edit', [
                "staff" => $staff,
                "roles" => $roles,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(StaffUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $staff = $this->userRepository->update($request->except("_token"), $id);

            $created_by = \Illuminate\Support\Facades\Auth::user()->name;
            $company = Settings('company_name');
            $content = 'Your info has been updated as a Staff by ' . $created_by . ' for ' . $company . ' ';
            $number = $staff->phone ?? '';
            $message = 'Your info Have Been updated by ' . $created_by . ' as a Staff for ' . $company . ' ';;
//            $this->sendNotification($staff, $staff->user->email, 'Staff Added', $content, $number, $message);
            DB::commit();
//            \LogActivity::successLog($request->username . '- profile has been updated.');
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));            return redirect()->route('staffs.index');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $staff = $this->userRepository->delete($id);
//            \LogActivity::successLog('Staff has been destroyed.');
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));            return back();
        } catch (\Exception $e) {
//            \LogActivity::errorLog($e->getMessage() . ' - Staff has been detected for Role Destroy');
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function status_update(Request $request)
    {
        try {
            $staff = $this->userRepository->statusUpdate($request->except("_token"));
//            \LogActivity::successLog('User Active Status has been updated.');
            return response()->json([
                'success' => trans('common.Operation successful')
            ]);
        } catch (\Exception $e) {
//            \LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => trans('common.Something Went Wrong')
            ]);
        }
    }

    public function document_store(Request $request)
    {
        try {
            if ($request->file('file') != "" && $request->name != "") {
                $file = $request->file('file');
                $document = 'staff-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

                if(!File::isDirectory('uploads/staff/document/')){
                    File::makeDirectory('uploads/staff/document/', 0777, true, true);
                }

                $file->move('uploads/staff/document/', $document);
                $document = 'uploads/staff/document/' . $document;
                $staffDocument = new StaffDocument();
                $staffDocument->name = $request->name;
                $staffDocument->staff_id = $request->staff_id;
                $staffDocument->documents = $document;
                $staffDocument->save();
            }
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function document_destroy($id)
    {
        try {
            $staff = $this->userRepository->deleteStaffDoc($id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));            return back();
        } catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage() . ' - detected for Staff Document Destroy');
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function profile_view()
    {
        try {
            $staffDetails = $this->userRepository->find(Auth::user()->staff->id);
            $leaveDetails = $this->leaveRepository->user_leave_history(Auth::user()->id);
            $total_leave = $this->leaveRepository->total_leave(Auth::user()->id);
            $apply_leave_histories = $this->leaveRepository->user_leave_history(Auth::user()->id);
            $payrollDetails = $this->payrollRepository->userPayrollDetails(Auth::user()->staff->id);
            $staffDocuments = $this->userRepository->findDocument(Auth::user()->staff->id);
            $loans = $this->applyLoanRepository->staffLoans(Auth::user()->id);
            return view('backEnd.profiles.profile', [
                "staffDetails" => $staffDetails,
                "leaveDetails" => $leaveDetails,
                "total_leave" => $total_leave,
                "staffDocuments" => $staffDocuments,
                "payrollDetails" => $payrollDetails,
                'apply_leave_histories' => $apply_leave_histories,
                "loans" => $loans
            ]);
        } catch (\Exception $e) {
            return back();
        }
    }

    public function profile_edit(Request $request)
    {
        try {
            $user = $this->userRepository->findUser($request->id);
            return view('backEnd.profiles.editProfile', [
                "user" => $user
            ]);
        } catch (\Exception $e) {
            return back();
        }
    }

    public function profile_update(Request $request, $id)
    {
        /*if (env('APP_SYNC')) {
            Toastr::error('Restricted in demo mode');
            return back();
        }*/
        $validation_rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.Auth::id(),
            'phone' => 'sometimes|nullable|unique:staffs,phone,'.Auth::user()->staff->id,
            'password' => 'sometimes|nullable|confirmed',
            'password_confirmation' => 'required_with:password'
        ];
        $request->validate($validation_rules, validationMessage($validation_rules));
        if (Auth::user()->role_id != 1)
        {
            $$validation_rules = [
                'bank_name' => 'required',
                'bank_branch_name' => 'required',
                'bank_account_name' => 'required',
                'bank_account_no' => 'required',
                'current_address' => 'required',
                'permanent_address' => 'required',
            ];
            $request->validate($validation_rules, validationMessage($validation_rules));
        }
        try {
            $this->userRepository->updateProfile($request->except("_token"), $id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));            Toastr::success(__('common.Staff info has been updated Successfully'));
            return back();

        } catch (\Exception $e) {
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function csv_upload()
    {
        return view('humanresource::staffs.upload_via_csv.create');
    }

    public function csv_upload_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048'
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();
        try {
            $this->userRepository->csv_upload_staff($request->except("_token"));
            DB::commit();
            Toastr::success('Successfully Uploaded !!!');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23000) {
                Toastr::error('Duplicate entry is exist in your file !!!');
            }
            else {
                Toastr::error('Something went wrong. Upload again !!!');
            }
            return back();
        }

    }
    public function active($id)
    {
        try{
            User::where('id',$id)->update(['is_active'=>1,'inactive_date'=>NULL, 'inactive_reason'=>NULL]);
            return response()->json(['status'=>200]);
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return  back();
        }

    }
    public function inactive($id)
    {
        try{
            $user = User::find($id);
            return view('humanresource::staffs.components._inactive_modal',['user'=>$user]);
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return  back();
        }

    }
    public function inactiveUpdate($id,Request $request)
    {
        try{
            User::where('id',$id)->update([
               'is_active' => 0,
               'inactive_date' => date('Y-m-d',strtotime($request->inactive_date)),
               'inactive_reason' => $request->reason,
            ]);
            return response()->json(['status'=>200]);
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return  back();

        }
    }
    public function documentUpload()
    {
        try{
            $data['documents'] = StaffDocument::where('staff_id',Auth::id())->get();
            return view('humanresource::staffs.components._document',$data);
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return  back();

        }
    }
    public function documentUploadStore(Request $request)
    {
//        dd($request->all());
        try{
            $validation_rules = [
                'documents.*.name'=>'nullable',
                'documents.*.file'=>'nullable|mimes:pdf,xlx,csv,jpg,jpeg,png,zip,xlsx',
            ];
            $request->validate($validation_rules, validationMessage($validation_rules));
            $upload_path='public/uploads/staff_document';
            if(isset($request->existing_document_ids)){
                foreach ($request->existing_document_ids as $eid){
                    $row = StaffDocument::find($eid);
                    if(isset($request->file[$eid]) && $row->documents){
                        $file_url = $this->fileUploadAndUpdate($request->file[$eid],$upload_path,$row->documents);
                    }elseif(isset($request->file[$eid]) && !$row->documents){
                        $file_url = $this->fileUpload($request->file[$eid],$upload_path);
                    }else{
                        $file_url = $row->documents;
                    }
                    StaffDocument::where('id',$eid)->update([
                        'name'=>$request->name[$eid],
                        'documents'=>$file_url,
                    ]);
                }
            }
            $documents = $request->documents;
            foreach ($documents as $document){
                if(isset($document['name']) && isset($document['file'])){
                    StaffDocument::create([
                        'staff_id'=>Auth::id(),
                        'name'=>$document['name'],
                        'documents'=>$this->fileUpload($document['file'],$upload_path),
                    ]);
                }
            }
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));            return  back();
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return  back();

        }
    }
    public function documentRemove($id)
    {
        try{
            $document = StaffDocument::find($id);
            $this->deleteImage($document->documents);
            $document->delete();
            return response()->json(['status'=>200]);
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return  back();

        }
    }
    public function staffResume($id = null)
    {
        try{
            if($id){
                $data['user'] = User::where('id',$id)->with('role')->first();
                return view('humanresource::staffs.components._resume_modal',$data);
            }else{
                $data['user'] = User::where('id', Auth::id())->with('role')->first();
                return view('humanresource::staffs.components._resume',$data);
            }
        }catch(\Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return  back();

        }
    }

    public function settings()
    {
        return view('humanresource::staffs.settings');
    }

    public function settingsPost(Request $request)
    {
        UpdateGeneralSetting('staff_can_view_course', $request->staff_can_view_course);
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
