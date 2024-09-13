<?php

namespace Modules\Appearance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Setting\Model\GeneralSetting;

class Theme extends Model
{
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            GenerateGeneralSetting();
            Cache::forget('frontend_active_theme');
            Cache::forget('getAllTheme');
            Cache::forget('color_theme');

        });

        self::updated(function ($model) {
            GenerateGeneralSetting();
            Cache::forget('frontend_active_theme');
            Cache::forget('getAllTheme');
            Cache::forget('color_theme');


        });

        self::deleted(function ($model) {
            GenerateGeneralSetting();
            Cache::forget('theme_customizes');
            Cache::forget('getAllTheme');
            Cache::forget('color_theme');

        });
    }

    public static function getAllData()
    {
        return Cache::rememberForever('getAllTheme', function () {
            return DB::table('theme_customizes')->get();
        });
    }

}
