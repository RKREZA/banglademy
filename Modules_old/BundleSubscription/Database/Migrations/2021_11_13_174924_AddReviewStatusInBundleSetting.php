<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviewStatusInBundleSetting extends Migration
{

    public function up()
    {

        if (Schema::hasColumn('general_settings', 'key')) {
            UpdateGeneralSetting('show_review_for_bundle_subscription', 1);
        } else {
            Schema::table('general_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('general_settings', 'show_review_for_bundle_subscription')) {
                    $table->tinyInteger('show_review_for_bundle_subscription')->default(1);
                }
            });
        }
    }

    public function down()
    {
        //
    }
}
