<?php

namespace Modules\BundleSubscription\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;


class BundleCoursePlan extends Model
{
    protected $guarded = ['id'];
    protected $with = ['reviews', 'course','user'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function reviews()
    {
        return $this->hasMany(BundleReveiw::class, 'bundle_id');
    }

    public function course()
    {
        return $this->hasMany(BundleCourse::class, 'plan_id');

    }

    public function getStarWiseReviewAttribute()
    {
        $data['1'] = $this->reviews->where('star', '1')->count();
        $data['2'] = $this->reviews->where('star', '2')->count();
        $data['3'] = $this->reviews->where('star', '3')->count();
        $data['4'] = $this->reviews->where('star', '4')->count();
        $data['5'] = $this->reviews->where('star', '5')->count();
        $data['total'] = $data['1'] + $data['2'] + $data['3'] + $data['4'] + $data['5'];
        return $data;
    }
}
