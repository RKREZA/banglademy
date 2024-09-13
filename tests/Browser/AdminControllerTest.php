<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminControllerTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                ->visit('login')
                ->type('email', 'support@spondonit.com')
                ->type('password', '12345678')
                ->assertSee('Laravel');
        });


    }


    public function testStudentListEditWithAuth()
    {
        $this->browse(function (Browser $browser) {

            $browser
                ->loginAs(1)
                ->visit('admin/student/allStudent')
                ->pause(10000)
                ->click('#lms_table > tbody > tr:nth-child(2) > td:nth-child(6) > div > button')
                ->pause(3000)
                ->click('#lms_table > tbody > tr:nth-child(2) > td:nth-child(6) > div > div > button.dropdown-item.editStudent')
                ->pause(3000)
                ->waitForText('Update Student')
                ->type('#studentName','abc')
                ->scrollIntoView('#save_button_parent')
                ->pause('3000')
                ->click('#save_button_parent')
                ->pause(3000)
                ->waitForText('Operation successful')
                ->assertSee('Operation successful')
                ->assertSee('Update Student');
/*                ->whenAvailable('#editStudent', function ($modal) {
                    $modal
                        ->type('#studentName', 'Mahadi Hassan Babu')
//                        ->type('#studentDob', '11/23/1997')
//                        ->type('#studentPhone', '01794965669')
//                        ->type('#studentEmail', 'mahadihassan.cse@gmail.com')
//                        ->type('#studentImage', '/public/assets/course/no_image.png')
//                        ->type('#password', '12345678')
                        // ->type('#password', '12345678')
                        // ->type('facebook', 'https://www.facebook.com')
                        // ->type('twitter', 'https://www.twitter.com')
                        // ->type('linkedin', 'https://www.linkedin.com')
                        // ->type('youtube', 'https://www.youtube.com')
                        ->click('#save_button_parent')
                        ->assertSee('Operation successful') ;
                });*/
        });


    }


}
