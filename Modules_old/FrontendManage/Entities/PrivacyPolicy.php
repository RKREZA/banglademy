<?php

namespace Modules\FrontendManage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Rennokki\QueryCache\Traits\QueryCacheable;

class PrivacyPolicy extends Model
{
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('PrivacyPolicy');
        });
        self::updated(function ($model) {
            Cache::forget('PrivacyPolicy');
        });
        self::deleted(function ($model) {
            Cache::forget('PrivacyPolicy');
        });
    }
    public static function getData()
    {
        return Cache::rememberForever('PrivacyPolicy', function () {
            return DB::table('privacy_policies')->select('*')->first();
        });
    }
}
