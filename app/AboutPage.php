<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AboutPage extends Model
{

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('AboutPage');
        });
        self::updated(function ($model) {
            Cache::forget('AboutPage');
        });
        self::deleted(function ($model) {
            Cache::forget('AboutPage');
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('AboutPage', function () {
            return DB::table('about_pages')->select('*')->first();
        });
    }

}
