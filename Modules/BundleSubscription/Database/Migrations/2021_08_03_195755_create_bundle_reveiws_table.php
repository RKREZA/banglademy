<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundleReveiwsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_reveiws', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('bundle_id');
            $table->boolean('status')->default(1);
            $table->text('comment');
            $table->float('star')->default(5);
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
        Schema::dropIfExists('bundle_reveiws');
    }
}
