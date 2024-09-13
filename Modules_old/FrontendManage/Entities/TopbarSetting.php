<?php

namespace Modules\FrontendManage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TopbarSetting extends Model
{
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('TopbarSetting');
        });
        self::updated(function ($model) {
            Cache::forget('TopbarSetting');
        });
        self::deleted(function ($model) {
            Cache::forget('TopbarSetting');
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('TopbarSetting', function () {
            return DB::table('	topbar_settings')->first();
        });
    }
}
