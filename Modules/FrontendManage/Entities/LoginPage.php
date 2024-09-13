<?php

namespace Modules\FrontendManage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LoginPage extends Model
{
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('login_page');
        });
        self::updated(function ($model) {
            Cache::forget('login_page');
        });
        self::deleted(function ($model) {
            Cache::forget('login_page');
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('login_page', function () {
            return DB::table('login_pages')->select('*')->first();
        });
    }
}
