<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CourseLevel extends Model
{
    protected $fillable = [];


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('CourseLevel');
        });
        self::updated(function ($model) {
            Cache::forget('CourseLevel');
        });
        self::deleted(function ($model) {
            Cache::forget('CourseLevel');
        });
    }

    public static function getAllActiveData()
    {
        return Cache::rememberForever('CourseLevel', function () {
            return DB::table('course_levels')->select('id', 'title')->where('status', 1)->get();
        });
    }
}
