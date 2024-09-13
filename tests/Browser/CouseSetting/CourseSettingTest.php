<?php

namespace Tests\Browser\CouseSetting;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CourseSettingTest extends DuskTestCase
{
    use withFaker;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreateCouse()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('admin/course/all/courses')
                ->click('#add_course_btn')
                ->waitFor('#add_course', 5)
                ->whenAvailable('#add_course', function ($modal)  {
                    $modal->click('#add_course > div > div > div.modal-body > form > div:nth-child(2) > div:nth-child(1) > div > div > div:nth-child(2) > label')
                        ->type('#addTitle',$this->faker->name)

                    ;
                })
                ->assertSee('Laravel');
        });
    }
}
