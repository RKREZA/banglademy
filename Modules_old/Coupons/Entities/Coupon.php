<?php
namespace Modules\Coupons\Entities;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Entities\Checkout;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Coupon extends Model
{


    protected $fillable = [];
    protected $dates = [
        'end_date',
        'start_date',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }
    public function coupon_user(){
        return $this->belongsTo(User::class,'coupon_user_id')->withDefault();
    }
    public function totalUsed(){
        return $this->hasMany(Checkout::class,'coupon_id');
    }
}
