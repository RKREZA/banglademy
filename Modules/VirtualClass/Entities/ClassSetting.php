<?php

namespace Modules\VirtualClass\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Rennokki\QueryCache\Traits\QueryCacheable;

class ClassSetting extends Model
{


    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('ClassSetting');
        });
        self::updated(function ($model) {
            Cache::forget('ClassSetting');
        });
        self::deleted(function ($model) {
            Cache::forget('ClassSetting');
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('ClassSetting', function () {
            return DB::table('class_settings')->select('*')->first();
        });
    }
}
