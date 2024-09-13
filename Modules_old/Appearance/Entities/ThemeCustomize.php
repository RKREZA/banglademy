<?php

namespace Modules\Appearance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ThemeCustomize extends Model
{
    protected $guarded = ['id'];

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id')->withDefault();
    }


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('theme_customizes');
            Cache::forget('color_theme');
        });
        self::updated(function ($model) {
            Cache::forget('theme_customizes');
            Cache::forget('color_theme');
        });
        self::deleted(function ($model) {
            Cache::forget('theme_customizes');
            Cache::forget('color_theme');
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('theme_customizes', function () {
            return DB::table('theme_customizes')->select('*')->first();
        });
    }
}
