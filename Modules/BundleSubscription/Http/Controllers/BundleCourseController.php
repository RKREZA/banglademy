<?php

namespace Modules\BundleSubscription\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Modules\BundleSubscription\Repositories\BundleCourseRepository;

class BundleCourseController extends Controller
{
    protected BundleCourseRepository $bundleCourse;

    public function __construct(BundleCourseRepository $bundleCourse)
    {
        $this->bundleCourse = $bundleCourse;
    }


    public function index(Request $request)
    {

        if (!isset($request->id)) {
            Toastr::error('Invalid request', 'Error');
            return redirect()->route('bundle.course');
        }

        try {
            $planId = $request->id;

            $courses = $this->bundleCourse->all();
            $assigns = $this->bundleCourse->get($planId);

            return view('bundlesubscription::backend.assign_course.index', compact('courses', 'assigns', 'planId'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }


    public function store(Request $request)
    {
        if (demoCheck()) {
            return false;
        }
        $rules = [
            'element_id' => 'required',
            'plan_id' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $this->bundleCourse->store($request->all());
            return $this->reloadWithData($request->plan_id);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    private function reloadWithData($id)
    {

        $courses = $this->bundleCourse->all();
        $assigns = $this->bundleCourse->get($id);


        return view('bundlesubscription::backend.assign_course.list', compact(
            'courses', 'assigns'));

    }

    public function destroy(Request $request)
    {
        if (demoCheck()) {
            return false;
        }
        try {
            $plan = $this->bundleCourse->delete($request->id);

            return $this->reloadWithData($plan);

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
