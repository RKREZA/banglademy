<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Rennokki\QueryCache\Traits\QueryCacheable;

class QuizeSetup extends Model
{


    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('QuizeSetup');
        });
        self::updated(function ($model) {
            Cache::forget('QuizeSetup');
        });
        self::deleted(function ($model) {
            Cache::forget('QuizeSetup');
        });
    }
    public static function getData()
    {
        return Cache::rememberForever('QuizeSetup', function () {
            return DB::table('quize_setups')->select('*')->first();
        });
    }
}
