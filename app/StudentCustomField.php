<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StudentCustomField extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('student_custom_field');
        });
        self::updated(function ($model) {
            Cache::forget('student_custom_field');
        });
        self::deleted(function ($model) {
            Cache::forget('student_custom_field');
        });
    }
    public static function getData()
    {
        return Cache::rememberForever('student_custom_field', function () {
            return DB::table('student_custom_fields')->select('*')->first();
        });
    }
}
