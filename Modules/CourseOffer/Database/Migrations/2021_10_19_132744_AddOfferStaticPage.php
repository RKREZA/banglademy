<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\FrontPage;

class AddOfferStaticPage extends Migration
{

    public function up()
    {
        Schema::table('front_pages', function (Blueprint $table) {
            $frontPage = FrontPage::where('slug', '/offer')->first();
            if (!$frontPage) {
                $frontPage = new FrontPage();
            }

            $frontPage->name = 'Course Offer';
            $frontPage->title = 'Course Offer';
            $frontPage->sub_title = 'Course Offer';
            $frontPage->details = 'Course Offer';
            $frontPage->slug = '/offer';
            $frontPage->status = 1;
            $frontPage->is_static = 1;
            $frontPage->save();
        });
    }


    public function down()
    {
        //
    }
}
