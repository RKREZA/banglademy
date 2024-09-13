<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOfferColumnInCousreTable extends Migration
{

    public function up()
    {
        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'offer')) {
                $table->boolean('offer')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
