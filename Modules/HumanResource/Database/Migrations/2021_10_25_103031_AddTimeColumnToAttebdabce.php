<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeColumnToAttebdabce extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function ($table) {
            if (!Schema::hasColumn('attendances', 'entering_time')) {
                $table->string('entering_time')->nullable();
            }
            if (!Schema::hasColumn('attendances', 'leaving_time')) {
                $table->string('leaving_time')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
