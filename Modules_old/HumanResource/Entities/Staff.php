<?php

namespace Modules\HumanResource\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\WareHouse;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Payroll\Entities\Payroll;
use Modules\Setup\Entities\Department;
use Modules\Setup\Entities\IntroPrefix;

class Staff extends Model
{
    use SoftDeletes;
    protected $table = 'staffs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(\Modules\HumanResource\Entities\Department::class)->withDefault();
    }

    public function payrolls(){
        return $this->hasMany(\Modules\HumanResource\Entities\Payroll::class, 'staff_id', 'id');
    }
}
