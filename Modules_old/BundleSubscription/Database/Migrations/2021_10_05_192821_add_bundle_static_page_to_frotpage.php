<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\FrontendManage\Entities\FrontPage;

class AddBundleStaticPageToFrotpage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('front_pages', function (Blueprint $table) {
            $frontPage = FrontPage::where('slug', '/bundle-subscription/1')->first();
            if (empty($frontPage)) {
                $frontPage = FrontPage::where('slug', '/bundle-subscription/courses')->first();
            }
            if (!$frontPage) {
                $frontPage = new FrontPage();
            }

            $frontPage->name = 'Bundle Subscription';
            $frontPage->title = 'Bundle Subscription';
            $frontPage->sub_title = 'Bundle Subscription';
            $frontPage->details = 'Bundle Subscription';
            $frontPage->slug = '/bundle-subscription/courses';
            $frontPage->status = 1;
            $frontPage->is_static = 1;
            $frontPage->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('front_pages', function (Blueprint $table) {

        });
    }
}
