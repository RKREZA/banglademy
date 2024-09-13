<?php

namespace Modules\PopupContent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PopupContent extends Model
{
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('popup_contents');
        });
        self::updated(function ($model) {
            Cache::forget('popup_contents');
        });
        self::deleted(function ($model) {
            Cache::forget('popup_contents');
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('popup_contents', function () {
            return DB::table('popup_contents')->select('*')->first();
        });
    }
}
