<?php

namespace Modules\FrontendManage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Rennokki\QueryCache\Traits\QueryCacheable;

class HomeContent extends Model
{


    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            GenerateHomeContent();
        });
        self::updated(function ($model) {
            GenerateHomeContent();
        });
    }
}
