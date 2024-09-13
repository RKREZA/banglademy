<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmStaffAttendencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_staff_attendences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attendence_type', 10)->nullable()->comment('Present: P Late: L Absent: A Holiday: H Half Day: F');
            $table->string('notes', 500)->nullable();
            $table->date('attendence_date')->nullable();
            $table->timestamps();

            $table->integer('staff_id')->nullable()->unsigned();

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('upapdated_by')->nullable()->default(1)->unsigned();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_staff_attendences');
    }
}
