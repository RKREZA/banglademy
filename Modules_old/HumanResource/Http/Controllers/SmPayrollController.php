<?php

namespace Modules\HumanResource\Http\Controllers;


use Modules\HumanResource\Entities\Staff as SmStaff;
use Carbon\Carbon;
use Modules\Account\Entities\SmAddExpense;
use Modules\Account\Entities\SmBankAccount;
use Modules\Leave\Entities\LeaveDefine as SmLeaveDefine;
use Modules\Account\Entities\SmBankStatement;
use Modules\Account\Entities\SmChartOfAccount;
use Modules\Account\Entities\SmPaymentMethhod;
use App\SmStaffAttendence;
use App\SmHrPayrollGenerate;
use Illuminate\Http\Request;
use App\SmHrPayrollEarnDeduc;
use Modules\Leave\Entities\SmLeaveDeductionInfo;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class SmPayrollController extends Controller
{
	public function __construct()
	{

	}

	public function index(Request $request)
	{

		try{
			$roles = [0 => 'Staff'];
			return view('backend.payroll.index', compact('roles'));
		}catch (\Exception $e) {
		   Toastr::error('Operation Failed', 'Failed');
		   return redirect()->back();
		}
	}

	public function searchStaffPayr(Request $request)
	{

//		$request->validate([
//			'role' => "required",
//			'payroll_month' => "required",
//			'payroll_year' => "required"
//
//		]);

		try{
			$role_id = $request->role_id;
			$payroll_month = $request->payroll_month;
			$payroll_year = $request->payroll_year;

			$staffs = SmStaff::all();

            $roles = [0 => 'Staff'];

            return view('backend.payroll.index', compact('staffs', 'roles', 'payroll_month', 'payroll_year', 'role_id'));
		}catch (\Exception $e) {
		   Toastr::error('Operation Failed', 'Failed');
		   return redirect()->back();
		}
	}


	public function generatePayroll(Request $request, $id, $payroll_month, $payroll_year)
	{


		try{
			$staffDetails = SmStaff::find($id);
			// return $staffDetails;
			$month = date('m', strtotime($payroll_month));
			$attendances = SmStaffAttendence::where('staff_id', $id)->where('attendence_date', 'like', $payroll_year . '-' . $month . '%')->get();

			$staff_leaves = SmLeaveDefine::where('user_id',$staffDetails->user_id)->where('role_id', $staffDetails->role_id)->get();
			$staff_leave_deduct_days = SmLeaveDeductionInfo::where('staff_id', $id)->where('pay_year', $payroll_year)->get()->sum("extra_leave");

			// return $payroll_year;
			foreach ($staff_leaves as $staff_leave) {
				//  $approved_leaves = SmLeaveRequest::approvedLeave($staff_leave->id);
					$remaining_days = $staff_leave->days - $staff_leave->remainingDays;
					$extra_Leave_days= $remaining_days < 0? $staff_leave->remainingDays - $staff_leave->days:0;
			}

			if ($staff_leave_deduct_days != "") {
				$extra_days = @$extra_Leave_days - @$staff_leave_deduct_days;
			} else {
				$extra_days = @$extra_Leave_days;
			}

			$p = 0;
			$l = 0;
			$a = 0;
			$f = 0;
			$h = 0;
			foreach ($attendances as $value) {
				if ($value->attendence_type == 'P') {
					$p++;
				} elseif ($value->attendence_type == 'L') {
					$l++;
				} elseif ($value->attendence_type == 'A') {
					$a++;
				} elseif ($value->attendence_type == 'F') {
					$f++;
				} elseif ($value->attendence_type == 'H') {
					$h++;
				}
			}


			return view('backend.payroll.generatePayroll', compact('staffDetails', 'payroll_month', 'payroll_year', 'p', 'l', 'a', 'f', 'h','extra_days'));
		}catch (\Exception $e) {

		   Toastr::error($e->getMessage(), 'Failed');
		   return redirect()->back();
		}
	}

	public function savePayrollData(Request $request)
	{
		$request->validate([
			'net_salary' => "required"
		]);
		try{
			$payrollGenerate = new SmHrPayrollGenerate();
			$payrollGenerate->staff_id = $request->staff_id;
			$payrollGenerate->payroll_month = $request->payroll_month;
			$payrollGenerate->payroll_year = $request->payroll_year;
			$payrollGenerate->basic_salary = $request->basic_salary;
			$payrollGenerate->total_earning = $request->total_earning;
			$payrollGenerate->total_deduction = $request->total_deduction;
			$payrollGenerate->gross_salary = $request->final_gross_salary;
			$payrollGenerate->tax = $request->tax;
			$payrollGenerate->net_salary = $request->net_salary;
			$payrollGenerate->payroll_status = 'G';
			$payrollGenerate->created_by = Auth()->user()->id;
			$result = $payrollGenerate->save();
			$payrollGenerate->toArray();

			if ($request->leave_deduction >0) {
				$leave_deduct = new SmLeaveDeductionInfo;
				$leave_deduct->staff_id = $request->staff_id;
				$leave_deduct->payroll_id = $payrollGenerate->id;
				$leave_deduct->extra_leave = $request->extra_leave_taken;
				$leave_deduct->salary_deduct = $request->leave_deduction;
				$leave_deduct->pay_month = $request->payroll_month;
				$leave_deduct->pay_year = $request->payroll_year;
				$leave_deduct->created_by = Auth()->user()->id;
				$leave_deduct->save();
			}

			if ($result) {
				$earnings = count($request->earningsType);
				for ($i = 0; $i < $earnings; $i++) {
					if (!empty($request->earningsType[$i]) && !empty($request->earningsValue[$i])) {
						$payroll_earn_deducs = new SmHrPayrollEarnDeduc;
						$payroll_earn_deducs->payroll_generate_id = $payrollGenerate->id;
						$payroll_earn_deducs->type_name = $request->earningsType[$i];
						$payroll_earn_deducs->amount = $request->earningsValue[$i];
						$payroll_earn_deducs->earn_dedc_type = 'E';
						$payroll_earn_deducs->created_by = Auth()->user()->id;
						$result = $payroll_earn_deducs->save();
					}
				}

				$deductions = count($request->deductionstype);
				for ($i = 0; $i < $deductions; $i++) {
					if (!empty($request->deductionstype[$i]) && !empty($request->deductionsValue[$i])) {
						$payroll_earn_deducs = new SmHrPayrollEarnDeduc;
						$payroll_earn_deducs->payroll_generate_id = $payrollGenerate->id;
						$payroll_earn_deducs->type_name = $request->deductionstype[$i];
						$payroll_earn_deducs->amount = $request->deductionsValue[$i];
						$payroll_earn_deducs->earn_dedc_type = 'D';
						$result = $payroll_earn_deducs->save();
					}
				}
				Toastr::success('Operation successful', 'Success');
				return redirect()->route('payroll');
			} else {
				Toastr::error('Insert Failed', 'Failed');
				return redirect()->back();
			}
		}catch (\Exception $e) {

		   Toastr::error($e->getMessage(), 'Failed');
		   return redirect()->back();
		}
	}

	public function paymentPayroll(Request $request, $id, $role_id)
	{
		try{
			$chart_of_accounts = SmChartOfAccount::where('type','E')->get();

			$payrollDetails = SmHrPayrollGenerate::find($id);

			$paymentMethods = SmPaymentMethhod::where('id', '!=', '4')
							->where('id', '!=', '5')->where('id', '!=', '6')
							->get();

			$account_id = SmBankAccount::all();

			return view('backEnd.payroll.paymentPayroll', compact('payrollDetails', 'paymentMethods', 'role_id','chart_of_accounts','account_id'));
		}catch (\Exception $e) {
		   Toastr::error('Operation Failed', 'Failed');
		   return redirect()->back();
		}
	}

	public function savePayrollPaymentData(Request $request)
	{
		$request->validate([
			'expense_head_id' => "required"
		]);

		try{
			$payroll_month = $request->payroll_month;
			$payroll_year = $request->payroll_year;

			$payments = SmHrPayrollGenerate::find($request->payroll_generate_id);
			$payments->payment_date = date('Y-m-d', strtotime($request->payment_date));
			$payments->payment_mode = $request->payment_mode;
			$payments->note = $request->note;
			$payments->payroll_status = 'P';
			$payments->updated_by = Auth()->user()->id;
			$result = $payments->update();

			$leave_deduct =SmLeaveDeductionInfo::where('payroll_id',$request->payroll_generate_id)->first();
			if (!empty($leave_deduct)) {
				$leave_deduct->active_status = 1;
				$leave_deduct->save();
			}


			if($result){
				$store = new SmAddExpense();
				$store->name = 'Staff Payroll';
				$store->expense_head_id = $request->expense_head_id;
				$store->payment_method_id = $request->payment_mode;
				if($request->payment_mode == 3){
					$store->account_id = $request->bank_id;
				}
				$store->date = Carbon::now();
				$store->amount = $payments->net_salary;
				$store->description = 'Staff Payroll Payment';
				$store->save();
				}


				if($request->payment_mode == 3){
					$bank=SmBankAccount::where('id',$request->bank_id)
					->where('school_id',Auth::user()->school_id)
					->first();
					$after_balance= $bank->current_balance - $payments->net_salary;

					$bank_statement= new SmBankStatement();
					$bank_statement->amount= $payments->net_salary;
					$bank_statement->after_balance= $after_balance;
					$bank_statement->type= 0;
					$bank_statement->details= "Staff Payroll Payment";
					$bank_statement->item_receive_id= $payments->id;
					$bank_statement->payment_date= date('Y-m-d', strtotime($request->payment_date));
					$bank_statement->bank_id= $request->bank_id;
					$bank_statement->payment_method= $request->payment_method;
					$bank_statement->save();


					$current_balance= SmBankAccount::find($request->bank_id);
					$current_balance->current_balance=$after_balance;
					$current_balance->update();
				}






			$staffs = SmStaff::where('active_status', '=', '1')->where('role_id', '=', $request->role_id)->where('school_id',Auth::user()->school_id)->get();
			$roles = [
			    4 => 'Staff'
            ];
			Toastr::success('Operation successful', 'Success');
			return view('backend.payroll.index', compact('staffs', 'roles', 'payroll_month', 'payroll_year'));
		}catch (\Exception $e) {
		   Toastr::error($e->getMessage(), 'Failed');
		   return redirect()->back();
		}
	}

	public function viewPayslip($id)
	{

		try{
			$schoolDetails = DB::table('general_settings')->first();
			$payrollDetails = SmHrPayrollGenerate::find($id);

			$payrollEarnDetails = SmHrPayrollEarnDeduc::where('active_status', '=', '1')->where('payroll_generate_id', '=', $id)->where('earn_dedc_type', '=', 'E')->get();

			$payrollDedcDetails = SmHrPayrollEarnDeduc::where('active_status', '=', '1')->where('payroll_generate_id', '=', $id)->where('earn_dedc_type', '=', 'D')->get();

			return view('backend.payroll.viewPayslip', compact('payrollDetails', 'payrollEarnDetails', 'payrollDedcDetails', 'schoolDetails'));
		}catch (\Exception $e) {
		   Toastr::error('Operation Failed', 'Failed');
		   return redirect()->back();
		}
	}

	public function printPayslip($id){

		try{
			$schoolDetails = DB::table('general_settings')->first();
			$payrollDetails = SmHrPayrollGenerate::find($id);

			$payrollEarnDetails = SmHrPayrollEarnDeduc::where('active_status', '=', '1')->where('payroll_generate_id', '=', $id)->where('earn_dedc_type', '=', 'E')->get();

			$payrollDedcDetails = SmHrPayrollEarnDeduc::where('active_status', '=', '1')->where('payroll_generate_id', '=', $id)->where('earn_dedc_type', '=', 'D')->get();

			return view('backend.payroll.payslip_print', compact('payrollDetails', 'payrollEarnDetails', 'payrollDedcDetails', 'schoolDetails'));
		}catch (\Exception $e) {
		   Toastr::error($e->getMessage(), 'Failed');
		   return redirect()->back();
		}


	}

	public function payrollReport(Request $request)
	{
		try{
			$roles = [
			    4 => 'Staff'
            ];
			return view('backend.payroll.report', compact('roles'));
		}catch (\Exception $e) {
		   Toastr::error('Operation Failed', 'Failed');
		   return redirect()->back();
		}
	}

	public function searchPayrollReport(Request $request)
	{
		$request->validate([
			'role_id' => "required",
			'payroll_month' => "required",
			'payroll_year' => "required"

		]);
		try{
			$role_id = $request->role_id;
			$payroll_month = $request->payroll_month;
			$payroll_year = $request->payroll_year;

			$staffsPayroll = SmHrPayrollGenerate::with('staffs')
                ->where('payroll_month', $request->payroll_month)
                ->where('payroll_year', $request->payroll_year)
                ->where('active_status', 1)
                ->where('payroll_status', 'P')
                ->get();

			return view('backend.payroll.report', compact('staffsPayroll', 'payroll_month', 'payroll_year', 'role_id'));
		}catch (\Exception $e) {
		   Toastr::error($e->getMessage(), 'Failed');
		   return redirect()->back();
		}
	}
}
