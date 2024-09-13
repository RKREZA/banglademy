<?php


namespace Modules\BundleSubscription\Repositories;

use Auth;
use Modules\BundleSubscription\Entities\BundleCourse;
use Modules\CourseSetting\Entities\Course;

class BundleCourseRepository
{

    public function all()
    {

        $user = Auth::user();

        if ($user->role_id == 1) {
            return Course::whereType(1)->whereStatus('1')->get();
        } else {
            return Course::whereType(1)->whereStatus('1')->where('user_id', $user->id)->get();
        }

    }

    public function get($id)
    {
        return BundleCourse::where('plan_id', $id)->get();
    }

    public function store(array $data)
    {
        if (!empty($data['element_id'])) {
            foreach ($data['element_id'] as $value) {
                $dpage = Course::findOrFail($value);

                $check = BundleCourse::where('plan_id', $data['plan_id'])
                    ->where('course_id', $value)->first();

                if (!$check) {
                    $list = new BundleCourse();
                    $list->plan_id = $data['plan_id'];
                    $list->course_id = $value;
                    $list->save();
                    $dpage->subscription = 1;
                    $dpage->save();
                }
            }
        }
        return true;

    }


    public function delete($id)
    {

        $element = BundleCourse::find($id);
        $plan = $element->plan_id;
        $element->delete();

        return $plan;

    }

}
