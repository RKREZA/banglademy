<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InstructorSetup extends Model
{
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('InstructorSetup');
        });
        self::updated(function ($model) {
            Cache::forget('InstructorSetup');
        });
        self::deleted(function ($model) {
            Cache::forget('InstructorSetup');
        });
    }
    public static function getData()
    {
        return Cache::rememberForever('InstructorSetup', function () {
            return DB::table('instructor_setups')->select('*')->first();
        });
    }
}
