<?php

namespace Modules\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class NewsletterSetting extends Model
{
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('newsletterSetting');
            Cache::forget('newsletterSettingData');
        });
        self::updated(function ($model) {
            Cache::forget('newsletterSetting');
            Cache::forget('newsletterSettingData');

        });

        self::deleted(function ($model) {
            Cache::forget('newsletterSetting');
            Cache::forget('newsletterSettingData');

        });
    }


    public static function getData()
    {
        return Cache::rememberForever('newsletterSetting', function () {
            return DB::table('newsletter_settings')->select('*')->first();
        });
    }
}
