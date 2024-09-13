<?php


namespace Modules\BundleSubscription\Repositories;


use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Modules\BundleSubscription\Entities\BundleCoursePlan;

class BundleCoursePlanRepository
{
    public function getAllActive()
    {
        return BundleCoursePlan::where('status', 1)->orderBy('order', 'asc')->with('reviews', 'course')->get();
    }

    public function getInstructorBundle($createdBy)
    {
        return BundleCoursePlan::where('user_id', $createdBy)->orderBy('order', 'asc')->with('reviews', 'course')->get();

    }

    public function all($createdBy = null)
    {
        $user = Auth::user();


        if (isset($user) && $user->role_id == 1) {
            return BundleCoursePlan::orderBy('order', 'asc')->with('reviews', 'course')->get();
        } elseif (isset($user) && $user->role_id == 2) {
            return BundleCoursePlan::where('user_id', $user->id)->orderBy('order', 'asc')->with('reviews', 'course')->get();
        } else {
            return [];
        }

    }


    public function datatable()
    {
        $user = Auth::user();

        if (isset($user) && $user->role_id == 1) {
            return BundleCoursePlan::orderBy('order', 'asc')->with('reviews', 'course')->get();
        } elseif (isset($user) && $user->role_id == 2) {
            return BundleCoursePlan::where('user_id', $user->id)->orderBy('order', 'asc')->with('reviews', 'course')->get();
        } else {
            return false;
        }
    }

    public function get($id)
    {
        return BundleCoursePlan::findOrFail($id);
    }

    public function store(array $data)
    {
        $total = BundleCoursePlan::latest()->count();
        $plan = new BundleCoursePlan();
        $plan->user_id = Auth::id();


        $plan->title = $data['title'];
        $plan->price = $data['price'];
        $plan->about = $data['about'];
        $plan->days = $data['days'];
        $plan->order = $total + 1;
        return $plan->save();
    }

    public function update(array $data)
    {


        $total = BundleCoursePlan::latest()->count();
        $plan = BundleCoursePlan::find($data['id']);


        $plan->title = $data['title'];
        $plan->price = $data['price'];
        $plan->about = $data['about'];
        $plan->days = $data['days'];
        $plan->order = $total + 1;
        return $plan->save();
    }

    public function delete($id)
    {
        $plan = BundleCoursePlan::find($id);
        if ($plan->course) {
            foreach ($plan->course as $course) {
                $course->delete();
            }
        }

        return $plan->delete();

    }


    public function changePosition(array $data)
    {
        if (demoCheck()) {
            return false;
        }

        if (count($data) != 0) {
            foreach ($data as $key => $id) {

                $course = BundleCoursePlan::find($id);
                if ($course) {
                    $course->order = $key + 1;
                    $course->save();
                }

            }
        }
        return true;
    }

    public function changeStatus($id, $status)
    {
        if (demoCheck()) {
            return false;
        }
        $course = BundleCoursePlan::findOrFail($id);
        $course->status = $status;
        if ($course->save()) {
            return 1;
        }
        return 0;
    }

}
