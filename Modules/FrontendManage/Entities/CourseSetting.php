<?php

namespace Modules\FrontendManage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CourseSetting extends Model
{
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('CourseSetting');
        });
        self::updated(function ($model) {
            Cache::forget('CourseSetting');
        });
        self::deleted(function ($model) {
            Cache::forget('CourseSetting');
        });
    }
    public static function getData()
    {
        return Cache::rememberForever('CourseSetting', function () {
            return DB::table('course_settings')->select('*')->first();
        });
    }
}
