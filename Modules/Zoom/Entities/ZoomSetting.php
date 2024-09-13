<?php

namespace Modules\Zoom\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Rennokki\QueryCache\Traits\QueryCacheable;

class ZoomSetting extends Model
{



    protected $guarded = ['id'];
    protected $table = 'zoom_settings';

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('ZoomSetting');
        });
        self::updated(function ($model) {
            Cache::forget('ZoomSetting');
        });
        self::deleted(function ($model) {
            Cache::forget('ZoomSetting');
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('ZoomSetting', function () {
            return DB::table('zoom_settings')->select('*')->first();
        });
    }
}
