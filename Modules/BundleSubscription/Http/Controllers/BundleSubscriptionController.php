<?php

namespace Modules\BundleSubscription\Http\Controllers;

use App\BillingDetails;
use App\Http\Controllers\Controller;
use App\InstructorSetting;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\BundleSubscription\Entities\BundleReveiw;
use Modules\BundleSubscription\Entities\BundleSetting;
use Modules\BundleSubscription\Repositories\BundleCoursePlanRepository;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Payment\Entities\Cart;
use Modules\Payment\Entities\Checkout;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class BundleSubscriptionController extends Controller
{

    protected BundleCoursePlanRepository $bundleCourse;

    public function __construct(BundleCoursePlanRepository $bundleCourse)
    {
        $this->bundleCourse = $bundleCourse;
    }


    public function index(Request $request)
    {

        try {
            $BundleCourse = $this->bundleCourse->getAllActive();
            $categories = Category::select('id', 'name', 'title', 'description', 'image', 'thumbnail', 'parent_id')
                ->with('childs')
                ->where('status', 1)
                ->whereNull('parent_id')
                ->withCount('courses')
                ->orderBy('position_order', 'ASC')->with('activeSubcategories', 'childs')
                ->get();

            $frontendContent =  app('getHomeContent');

            return view(theme('pages.bundlesubscription_index'), compact('BundleCourse', 'categories', 'frontendContent'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }


    }


    public function show(Request $request)
    {
        try {
            if (empty($request->id)) {
                Toastr::error('Something Went Wrong', trans('common.Failed'));
                return redirect()->to('/');
            }
            $course = $this->bundleCourse->get($request->id);
            if (!isViewable($course)) {
                Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                return redirect()->to(route('courses'));
            }
            $isEnrolled = CourseEnrolled::where('user_id', Auth::id())->where('bundle_course_id', $request->id)->first();

            $reviewer_user_ids = [];
            foreach ($course->reviews as $key => $review) {
                $reviewer_user_ids[] = $review->user_id;
            }

            $frontendContent = app('getHomeContent');

            return view(theme('pages.bundlesubscription_show'), compact('course', 'isEnrolled', 'reviewer_user_ids', 'frontendContent'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function BundleCheckOut(Request $request)
    {

        try {

            Cart::where('user_id', Auth::id())->truncate();

            $bundle = BundleCoursePlan::findOrFail($request->bundle_id);


            $mainPrice = 0;
            $traking_code = getTrx();
            foreach ($bundle->course as $value) {

                $course = Course::find($value->course_id);
                $cart = new Cart();
                $cart->user_id = Auth::id();
                $cart->instructor_id = $course->user_id;
                $cart->course_id = $value->course_id;
                $cart->tracking = $traking_code;
                $cart->price = $course->price;
                $cart->bundle_course_id = $bundle->id;
                $cart->bundle_course_validity = $bundle->days ? Carbon::now()->addDays($bundle->days) : null;
                $mainPrice += $course->price;
                $cart->save();
            }

            $type = $request->type;
            if (!empty($type)) {
                $current = BillingDetails::where('user_id', Auth::id())->latest()->first();
            } else {
                $current = '';
            }

            $profile = Auth::user();
            $profile->cityName = $profile->cityName();
            $bills = BillingDetails::with('country')->where('user_id', Auth::id())->latest()->get();

            $countries = DB::table('countries')->select('id', 'name')->get();
            $cities = DB::table('spn_cities')->where('country_id', $profile->country)->select('id', 'name')->get();


            $tracking = Cart::where('user_id', Auth::id())->first()->tracking;


            $checkout = Checkout::where('tracking', $tracking)->where('user_id', Auth::id())->latest()->first();


            if (!$checkout)
                $checkout = new Checkout();

            $checkout->discount = 0;

            $checkout->tracking = $tracking;
            $checkout->user_id = Auth::id();
            $checkout->price = $bundle->price;
            $checkout->course_type = 'bundle';
            $checkout->payment_type = 'new';
            if (hasTax()) {
                $checkout->purchase_price = applyTax($bundle->price);
                $checkout->tax = taxAmount($bundle->price);
            } else {
                $checkout->purchase_price = $bundle->price;
            }
            $checkout->status = 0;
            $checkout->save();
            $methods = PaymentMethod::where('active_status', 1)->get(['method', 'logo']);

            $carts = Cart::where('user_id', Auth::id())->with('course', 'course.user')->get();


            return view(theme('checkout'), compact('bundle', 'current', 'methods', 'bills', 'checkout', 'profile', 'countries', 'cities', 'carts'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function Bundlecart(Request $request)
    {
        $bundle = BundleCoursePlan::findOrFail($request->bundle_id);

        try {

            $oldCart = Cart::where('user_id', Auth::id())->first();

            $user = Auth::user();

            if (isset($exist)) {
                Toastr::error('Course already added in your cart', 'Failed');
                return redirect()->back();
            } elseif (Auth::check() && ($user->role_id == 1)) {
                Toastr::error('You logged in as admin so can not add cart !', 'Failed');
                return redirect()->back();
            }

            if (!$oldCart) {
                $traking_code = getTrx();
            } else {
                $traking_code = $oldCart->tracking;
            }
            $cart = Cart::where('user_id', Auth::id())->where('bundle_course_id', $request->bundle_id)->first();
            if (!$cart) {
                $cart = new Cart();
            }
            $cart->user_id = Auth::id();
            $cart->instructor_id = $bundle->user_id;
            $cart->course_id = 0;
            $cart->tracking = $traking_code;
            $cart->price = $bundle->price;
            $cart->bundle_course_id = $bundle->id;
            $cart->bundle_course_validity = $bundle->days ? Carbon::now()->addDays($bundle->days) : null;
            $cart->save();
            Toastr::success('Course Added to your cart', 'Success');
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function dashboard()
    {


        try {
            $enroll = CourseEnrolled::where('user_id', Auth::id())->where('bundle_course_id', '!=', 0)->get()->unique('bundle_course_id');
            $bundle = BundleCoursePlan::all();

            $data = [];

            foreach ($enroll as $value) {
                foreach ($bundle as $value2) {
                    if ($value->bundle_course_id == $value2->id) {
                        $value2->buyDate = $value->updated_at;
                        $value2->expire = $value->bundle_course_validity;
                        array_push($data, $value2);
                    }
                }
            }


            return view(theme('pages.bundlesubscription_panel'), compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function BundleRenew(Request $request)
    {

        try {

            $bundle = BundleCoursePlan::findOrFail($request->bundle_id);
            Cart::where('user_id', Auth::id())->truncate();

            $cart = Cart::where('user_id', Auth::id())->where('bundle_course_id', $request->bundle_id)->first();
            if (!$cart) {
                $cart = new Cart();
            }
            $cart->user_id = Auth::id();
            $cart->instructor_id = $bundle->user_id;
            $cart->course_id = 0;
            $cart->tracking = getTrx();
            $cart->price = $bundle->price;
            $cart->bundle_course_id = $bundle->id;
            $cart->bundle_course_validity = $bundle->days ? Carbon::now()->addDays($bundle->days) : null;
            $cart->renew = 1;
            $cart->save();
            return redirect()->route('CheckOut');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function BundleReview(Request $request)
    {

        try {
            $bundleReview = new BundleReveiw();
            $bundleReview->user_id = Auth::id();
            $bundleReview->bundle_id = $request->bundle_id;
            $bundleReview->star = $request->rating;
            $bundleReview->comment = $request->review;
            $bundleReview->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function deleteBundleReview($id)
    {

        try {
            $bundleReview = BundleReveiw::findOrFail($id);
            $bundleReview->delete();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }


    public function setting()
    {
        try {

            $setting = BundleSetting::getData();
            return view('bundlesubscription::backend.setting.index', compact('setting'));

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }


    public function settingStore(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'commission_rate' => 'numeric|min:0|max:100',
        ]);

        try {
            $setting = BundleSetting::first();

            $setting->commission_rate = $request->commission_rate;
            $setting->save();


            if ($request->show_bundle_in_instructor_profile == 1) {
                UpdateGeneralSetting('show_bundle_in_instructor_profile', 1);
            } else {
                UpdateGeneralSetting('show_bundle_in_instructor_profile', 0);
            }

            if ($request->show_review_for_bundle_subscription == 1) {
                UpdateGeneralSetting('show_review_for_bundle_subscription', 1);
            } else {
                UpdateGeneralSetting('show_review_for_bundle_subscription', 0);
            }

            GenerateGeneralSetting();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return redirect()->back();

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            return redirect()->back();
        }
    }


    public function instructor()
    {

        try {
            $block = InstructorSetting::orderBy('order')->get();

            return view('bundlesubscription::block', compact('block'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }


    public function instructorPosition(Request $request)
    {

        if (demoCheck()) {
            return false;
        }

        $data = $request->get('ids');


        if ($data != 0) {
            foreach ($data as $key => $id) {

                $block = InstructorSetting::find($id);
                if ($block) {
                    $block->order = $key + 1;
                    $block->save();
                }

            }
        }
    }

}
