<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CookieSetting extends Model
{
    protected $fillable = [];


    public static function boot()
    {
        parent::boot();


        self::created(function ($model) {
            Cache::forget('cookie');
            Cache::forget('CookieSetting');
        });


        self::updated(function ($model) {
            Cache::forget('cookie');
            Cache::forget('CookieSetting');
        });

        self::deleted(function ($model) {
            Cache::forget('cookie');
            Cache::forget('CookieSetting');
        });
    }


    public static function getData()
    {
        return Cache::rememberForever('CookieSetting', function () {
            return DB::table('cookie_settings')->select('image', 'details', 'btn_text', 'text_color', 'bg_color', 'allow')->first();
        });
    }
}
