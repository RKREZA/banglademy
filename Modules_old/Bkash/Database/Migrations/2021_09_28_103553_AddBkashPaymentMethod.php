<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBkashPaymentMethod extends Migration
{

    public function up()
    {
        DB::table('payment_methods')->insert([[
            'method' => 'Bkash',
            'type' => 'System',
            'active_status' => 0,
            'module_status' => 1,
            'logo' => 'public/demo/gateway/bkash.png',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);
    }


    public function down()
    {
        //
    }
}
