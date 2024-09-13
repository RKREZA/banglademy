<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;
use Modules\FrontendManage\Entities\HomeContent;

class AddHomePageFaqInHomeContent extends Migration
{

    public function up()
    {
//        Schema::table('home_contents', function ($table) {
//            if (!Schema::hasColumn('home_contents', 'show_home_page_faq')) {
//                $table->integer('show_home_page_faq')->default(0);
//            }
//
//            if (!Schema::hasColumn('home_contents', 'home_page_faq_title')) {
//                $table->text('home_page_faq_title')->nullable();
//            }
//            if (!Schema::hasColumn('home_contents', 'home_page_faq_sub_title')) {
//                $table->text('home_page_faq_sub_title')->nullable();
//            }
//        });

        DB::table('home_contents')
            ->insert([
                'key' => 'home_page_faq_title',
                'value' => 'FAQ',
            ]);

        DB::table('home_contents')
            ->insert([
                'key' => 'show_home_page_faq',
                'value' => '0',
            ]);

        DB::table('home_contents')
            ->insert([
                'key' => 'home_page_faq_sub_title',
                'value' => 'Some common question & answer',
            ]);


        $homepage_block_positions = DB::table('homepage_block_positions')->orderBy('order', 'asc')->get();

        $check = DB::table('home_contents')->where('key', 'homepage_block_positions')->first();
        if ($check) {
            DB::table('home_contents')
                ->where('key', 'homepage_block_positions')
                ->update(['value' => json_encode($homepage_block_positions)]);
        } else {
            DB::table('home_contents')
                ->insert([
                    'key' => 'homepage_block_positions',
                    'value' => json_encode($homepage_block_positions),
                ]);
        }


        $path = Storage::path('homeContent.json');
        $setting = HomeContent::get(['key', 'value'])->pluck('value', 'key')->toJson();
        file_put_contents($path, $setting);
    }

    public function down()
    {
        //
    }
}
