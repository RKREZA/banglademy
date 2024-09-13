<?php

namespace App\Repositories;


use App\User;
use App\Subscription;
use App\Traits\ImageStore;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use DrewM\MailChimp\MailChimp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Importer;
use Modules\Coupons\Entities\UserWiseCoupon;
use Modules\HumanResource\Entities\Staff;
use Modules\HumanResource\Entities\StaffDocument;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\RolePermission\Entities\Role;

class UserRepository implements UserRepositoryInterface
{
    use ImageStore;


    public function create(array $data)
    {

        $user = User::create($data);

        $user->dob = $data['dob'] ?? null;
        $user->gender = $data['gender'] ?? null;
        $user->student_type = $data['student_type'] ?? null;
        $user->job_title = $data['job_title'] ?? null;
        $user->identification_number = $data['identification_number'] ?? null;
        $user->company_id = $data['company_id'] ?? null;

        $user->referral = generateUniqueId();
        $user->save();

        if (session::get('referral') != null) {
            $invited_by = User::where('referral', session::get('referral'))->first();
            $user_coupon = new UserWiseCoupon();
            $user_coupon->invite_by = $invited_by->id;
            $user_coupon->invite_accept_by = $user->id;
            $user_coupon->invite_code = session::get('referral');
            $user_coupon->save();
        }


        $mailchimpStatus = env('MailChimp_Status') ?? false;
        $getResponseStatus = env('GET_RESPONSE_STATUS') ?? false;
        $acelleStatus = env('ACELLE_STATUS') ?? false;
        if (hasTable('newsletter_settings')) {
            $setting = NewsletterSetting::getData();
            if ($data['role_id'] == 2) {

                if ($setting->instructor_status == 1) {
                    $list = $setting->instructor_list_id;
                    if ($setting->instructor_service == "Mailchimp") {

                        if ($mailchimpStatus) {
                            try {
                                $MailChimp = new MailChimp(env('MailChimp_API'));
                                $MailChimp->post("lists/$list/members", [
                                    'email_address' => $data['email'],
                                    'status' => 'subscribed',
                                ]);

                            } catch (\Exception $e) {
                            }
                        }
                    } elseif ($setting->instructor_service == "GetResponse") {
                        if ($getResponseStatus) {

                            try {
                                $getResponse = new \GetResponse(env('GET_RESPONSE_API'));
                                $getResponse->addContact(array(
                                    'email' => $data['email'],
                                    'campaign' => array('campaignId' => $list),
                                ));
                            } catch (\Exception $e) {

                            }
                        }
                    } elseif ($setting->instructor_service == "Acelle") {
                        if ($acelleStatus) {

                            try {
                                $email = $data['email'];
                                $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                                $acelleController = new AcelleController();
                                $response = $acelleController->curlPostRequest($make_action_url);
                            } catch (\Exception $e) {

                            }
                        }
                    } elseif ($setting->instructor_service == "Local") {
                        try {
                            $check = Subscription::where('email', '=', $data['email'])->first();
                            if (empty($check)) {
                                $subscribe = new Subscription();
                                $subscribe->email = $data['email'];
                                $subscribe->type = 'Instructor';
                                $subscribe->save();
                            } else {
                                $check->type = "Instructor";
                                $check->save();
                            }
                        } catch (\Exception $e) {

                        }
                    }
                }


            } elseif ($data['role_id'] == 3) {
                if ($setting->student_status == 1) {
                    $list = $setting->student_list_id;
                    if ($setting->student_service == "Mailchimp") {

                        if ($mailchimpStatus) {
                            try {
                                $MailChimp = new MailChimp(env('MailChimp_API'));
                                $MailChimp->post("lists/$list/members", [
                                    'email_address' => $data['email'],
                                    'status' => 'subscribed',
                                ]);

                            } catch (\Exception $e) {
                            }
                        }
                    } elseif ($setting->student_service == "GetResponse") {
                        if ($getResponseStatus) {

                            try {
                                $getResponse = new \GetResponse(env('GET_RESPONSE_API'));
                                $getResponse->addContact(array(
                                    'email' => $data['email'],
                                    'campaign' => array('campaignId' => $list),
                                ));
                            } catch (\Exception $e) {

                            }
                        }
                    } elseif ($setting->student_service == "Acelle") {
                        if ($acelleStatus) {

                            try {
                                $email = $data['email'];
                                $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                                $acelleController = new AcelleController();
                                $response = $acelleController->curlPostRequest($make_action_url);
                            } catch (\Exception $e) {

                            }
                        }
                    } elseif ($setting->student_service == "Local") {
                        try {
                            $check = Subscription::where('email', '=', $data['email'])->first();
                            if (empty($check)) {
                                $subscribe = new Subscription();
                                $subscribe->email = $data['email'];
                                $subscribe->type = 'Student';
                                $subscribe->save();
                            } else {
                                $check->type = "Student";
                                $check->save();
                            }
                        } catch (\Exception $e) {

                        }
                    }
                }

            }
        }


        if (Settings('email_verification') != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();
        } else {
            $user->sendEmailVerificationNotification();
        }

        return $user;
    }

    public function store(array $data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->username = $data['username'];
        $user->role_id = $data['role_id'];
        $user->country = $data['country'];
        if (isset($data['photo'])) {
            $data = Arr::add($data, 'avatar', $this->saveAvatar($data['photo']));
            $user->image = $data['avatar'];
        }
        $user->password = Hash::make($data['password']);
        if (Settings('email_verification') != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();
        } else {
            $user->sendEmailVerificationNotification();
        }
        return $user;
    }


    public function update(array $data, $id)
    {
        $user = User::findOrFail($id);
        if (Hash::check($data['password'], Auth::user()->password)) {
            if (isset($data['photo'])) {
                $data = Arr::add($data, 'avatar', $this->saveAvatar($data['photo']));
                $user->image = $data['avatar'];
            }
            $user->name = $data['name'];
            $user->username = $data['username'];
            $user->role_id = $data['role_id'];
            $user->password = Hash::make($data['password']);
            if ($user->save()) {
                $staff = $user->staff;
                $staff->user_id = $user->id;
                $staff->department_id = $data['department_id'];
                $staff->employee_id = $data['employee_id'];
                $staff->showroom_id = $data['showroom_id'];
                // $staff->warehouse_id = $data['warehouse_id'];
                $staff->phone = $data['phone'];
                if ($staff->save()) {
                    if (Settings('email_verification') != 1) {
                        $user->email_verified_at = date('Y-m-d H:m:s');
                        $user->save();
                    } else {
                        $user->sendEmailVerificationNotification();
                    }
                }
                return $user;
            }
        }
    }


    ///////



    public function user()
    {
        return User::with('leaves','leaveDefines')->latest()->get();
    }

    public function all($relational_keyword = [])
    {
        if (count($relational_keyword) > 0) {
            return Staff::latest()->get();
        }else {
            return Staff::latest()->get();
        }

    }

    public function find($id)
    {
        return Staff::with('user')->findOrFail($id);
    }

    public function findUser($id)
    {
        return User::findOrFail($id);
    }

    public function findDocument($id)
    {
        return StaffDocument::where('staff_id', $id)->get();
    }


    public function updateProfile(array $data, $id)
    {
        $user = User::findOrFail($id);
        if (isset($data['avatar'])) {
            $user->avatar = $this->saveAvatar($data['avatar'],60,60);
        }
        $user->name = $data['name'];
        if(isset($data['password']) and $data['password']){
            $user->password = bcrypt($data['password']);
        }

        $result = $user->save();
        $staff = $user->staff;
        if($result){
            $staff->phone = $data['phone'];
            if ($user->role_id != 1) {
                $staff->bank_name = $data['bank_name'];
                $staff->bank_branch_name = $data['bank_branch_name'];
                $staff->bank_account_name = $data['bank_account_name'];
                $staff->bank_account_no = $data['bank_account_no'];
                $staff->current_address = $data['current_address'];
                $staff->permanent_address = $data['permanent_address'];
            }

            $staff->save();
        }
        return $staff;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if (File::exists($user->avatar)) {
            File::delete($user->avatar);
        }
        if ($user->staff){
            if ($user->staff->payrolls){
                $user->staff->payrolls()->delete();
            }
            $user->staff->delete();
        }


        $user->delete();
    }

    public function statusUpdate($data)
    {
        $user = User::find($data['id']);
        $user->is_active = $data['status'];
        $user->save();
    }

    public function deleteStaffDoc($id)
    {
        $document = StaffDocument::findOrFail($id)->delete();
    }

    public function normalUser()
    {
        $normal_roles_id = Role::where('type', 'regular_user')->pluck('id');
        return User::where('id',Auth::id())->orwhereIn('role_id',$normal_roles_id)->get();
    }

    public function roleUsers($role_id)
    {
        return User::where('role_id', $role_id)->where('is_active',1)->get();
    }
    /*
        public function csv_upload_staff($data)
        {
            if (!empty($data['file'])) {
                ini_set('max_execution_time', 0);
                $a = $data['file']->getRealPath();
                $column_name = Importer::make('Excel')->load($a)->getCollection()->skip(1)->first();

                foreach (Importer::make('Excel')->load($a)->getCollection()->skip(2) as $ke => $row) {

                    if(checkEmail($row[1])){
                        $user = User::create([
                            $column_name[0] => $row[0],
                            $column_name[1] => $row[1],
                            $column_name[2] => $row[2],
                            $column_name[3] => bcrypt($row[3]),
                            'role_id' => 3,
                            'email_verified_at' => date('Y-m-d H:m:s')
                        ]);
                    }else{
                        $user = User::create([
                            $column_name[0] => $row[0],
                            $column_name[2] => $row[2],
                            $column_name[3] => bcrypt($row[3]),
                            'role_id' => 3,
                            'email_verified_at' => date('Y-m-d H:m:s')
                        ]);
                    }

                    $staff = Staff::create([
                        'user_id' => $user->id,
                        'department_id' => 1,
                        'showroom_id' => 1,
                        $column_name[4] => $row[4],
                        $column_name[5] => Carbon::parse($row[5])->format('Y-m-d'),
                        $column_name[6] => $row[6],
                        $column_name[7] => $row[7],
                        $column_name[8] => $row[8],
                        $column_name[9] => $row[9],
                        $column_name[10] => $row[10],
                        $column_name[11] => $row[11],
                        $column_name[12] => $row[12],
                        $column_name[13] => $row[13],
                        $column_name[14] => $row[14],
                        $column_name[15] => empty($row[15]) ? null : Carbon::parse($row[15])->format('Y-m-d'),
                    ]);


                    $this->create_chart_account($user, $staff);
                }
            }
        }*/


}
