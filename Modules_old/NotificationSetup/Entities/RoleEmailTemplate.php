<?php

namespace Modules\NotificationSetup\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SystemSetting\Entities\EmailTemplate;

class RoleEmailTemplate extends Model
{
    protected $fillable = [];

    public function template(){
          return $this->belongsTo(EmailTemplate::class, 'template_act','act')->withDefault();
    }
}
