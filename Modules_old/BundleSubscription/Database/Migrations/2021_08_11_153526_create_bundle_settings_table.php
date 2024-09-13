<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\BundleSubscription\Entities\BundleSetting;

class CreateBundleSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('commission_rate');
            $table->timestamps();
        });

        $setting = new BundleSetting();
        $setting->commission_rate = 50;
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bundle_settings');
    }
}
