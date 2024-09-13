<?php

namespace Modules\BundleSubscription\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BundleReveiw extends Model
{
    protected $guarded = ['id'];

    protected $with = ['user'];

    public function plan()
    {
        return $this->belongsTo(BundleCoursePlan::class, 'bundle_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
