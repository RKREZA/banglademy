<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBundleToCourseEnrolledsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_enrolleds', function (Blueprint $table) {
            if (!Schema::hasColumn('course_enrolleds', 'bundle_course_id')) {
                $table->integer('bundle_course_id')->unsigned()->default(0);
            }
            if (!Schema::hasColumn('course_enrolleds', 'bundle_course_validity')) {
                $table->date('bundle_course_validity')->nullable();
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
        Schema::table('course_enrolleds', function (Blueprint $table) {

        });
    }
}
