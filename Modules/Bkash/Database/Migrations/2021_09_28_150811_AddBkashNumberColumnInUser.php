<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBkashNumberColumnInUser extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bkash_number')) {
                $table->string('bkash_number')->nullable();
            }
        });
    }


    public function down()
    {
        //
    }
}
