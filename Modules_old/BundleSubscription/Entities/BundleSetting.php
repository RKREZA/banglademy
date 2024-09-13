<?php

namespace Modules\BundleSubscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BundleSetting extends Model
{
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('BundleSetting');
        });
        self::updated(function ($model) {
            Cache::forget('BundleSetting');
        });
        self::deleted(function ($model) {
            Cache::forget('BundleSetting');
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('BundleSetting', function () {
            return DB::table('bundle_settings')->first();
        });
    }
}
