<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StudentSetup extends Model
{
    protected $fillable = [];


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('student_setups');
        });
        self::updated(function ($model) {
            Cache::forget('student_setups');
        });
        self::deleted(function ($model) {
            Cache::forget('student_setups');
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('student_setups', function () {
            return DB::table('student_setups')->select('*')->first();
        });
    }
}
