<?php

namespace Modules\BundleSubscription\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\BundleSubscription\Repositories\BundleCoursePlanRepository;
use Yajra\DataTables\DataTables;

class BundleCoursePlanController extends Controller
{
    protected BundleCoursePlanRepository $bundleCoursePlan;

    public function __construct(BundleCoursePlanRepository $bundleCoursePlan)
    {
        $this->bundleCoursePlan = $bundleCoursePlan;
    }

    public function index()
    {
        try {
            $BundleCoursePlan = $this->bundleCoursePlan->all();

            return view('bundlesubscription::backend.bundle_course.index', compact('BundleCoursePlan'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function datatable(Request $request)
    {

        try {
            return Datatables::of($this->bundleCoursePlan->datatable())
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    return view('bundlesubscription::backend.bundle_course.components.status', compact('data'));
                })
                ->editColumn('days', function ($data) {
                    if ($data->days == 0 || $data->days == "") {
                        $days = 'Life Time';
                    } else {
                        $days = $data->days;
                    }
                    return $days;
                })->addColumn('action', function ($data) {
                    return view('bundlesubscription::backend.bundle_course.components.action', compact('data'));
                })->rawColumns(['action', 'status'])
                ->make(true);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function store(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'title' => 'required|unique:bundle_course_plans,title',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $this->bundleCoursePlan->store($request->all());
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function edit(Request $request)
    {
        $bundlePlan = BundleCoursePlan::findOrFail($request->id);
        return view('bundlesubscription::backend.bundle_course.edit', compact('bundlePlan'));
    }

    public function update(Request $request)
    {
        try {
            $this->bundleCoursePlan->update($request->all());
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function delete($id)
    {
        try {
            $this->bundleCoursePlan->delete($id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function changePosition(Request $request)
    {
        $this->bundleCoursePlan->changePosition($request->get('ids'));
    }

    public function changeStatus(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        $this->bundleCoursePlan->changeStatus($id, $status);
    }
}
