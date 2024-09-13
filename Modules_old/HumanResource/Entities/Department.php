<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    protected $table = 'hr_departments';

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'user_id', 'id');
    }
}
