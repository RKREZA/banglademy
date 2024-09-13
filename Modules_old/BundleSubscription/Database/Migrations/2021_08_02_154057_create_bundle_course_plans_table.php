<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundleCoursePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_course_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->decimal('price',13,2);
            $table->string('about');
            $table->integer('days')->nullable();
            $table->boolean('status');
            $table->integer('order');
            $table->string('button_text');
            $table->integer('student')->default(0);
            $table->integer('user_id');
            $table->integer('reveune')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bundle_course_plans');
    }
}
