<?php

namespace Modules\CourseOffer\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CourseSetting\Entities\Course;

class CourseOfferController extends Controller
{

    public function index()
    {
        try {
            $query = Course::where('type', 1)->where('status', 1);
            $courses = $query->get();
            $assigns = $query->where('offer', 1)->get();
            return view('courseoffer::index', compact('courses', 'assigns'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function store(Request $request)
    {
        UpdateGeneralSetting('offer_type',$request->offer_type ?? 0);
        UpdateGeneralSetting('offer_amount',$request->offer_amount ?? 0);

        GenerateGeneralSetting();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function addOfferCourse(Request $request)
    {
        if (demoCheck()) {
            return false;
        }

        try {
            Course::whereIn('id', $request->element_id)->update(['offer' => 1]);
            return $this->reloadWithData();
        } catch (\Exception $e) {
            return '';
        }
    }

    public function removeOfferCourse(Request $request)
    {
        if (demoCheck()) {
            return false;
        }
        try {
            Course::where('id', $request->id)->update(['offer' => 0]);
            return $this->reloadWithData();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    private function reloadWithData()
    {
        $query = Course::where('type', 1)->where('status', 1);
        $courses = $query->get();
        $assigns = $query->where('offer', 1)->get();

        return view('courseoffer::list', compact(
            'courses', 'assigns'));
    }

}
