<?php

namespace Tests\Auth\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
//    use DatabaseMigrations;

    public function testInvalidLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->type('email', 'spn19@notemail.com')
                ->type('password', '123456')
                ->click(' div.login_wrapper > div.login_wrapper_left > div.login_wrapper_content > form > div > div:nth-child(5) > button')
                ->waitFor('.is-invalid')
                ->assertSee('login with Email Address');
        });
    }


    public function testEmptyEmailLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->type('password', '123456')
                ->click(' div.login_wrapper > div.login_wrapper_left > div.login_wrapper_content > form > div > div:nth-child(5) > button')
                ->assertSee('The email field is required.');


        });
    }
//->pause(2000) //
    public function testEmptyEmailPassword()
    {
        $this->browse(function (Browser $browser) {

            $browser->visitRoute('login')
                ->type('email', 'support@spondonit.com')
                ->click(' div.login_wrapper > div.login_wrapper_left > div.login_wrapper_content > form > div > div:nth-child(5) > button')
                ->assertSee('The password field is required.');

        });
    }

    public function testAdminSuccessfulLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visitRoute('logout')
                ->visitRoute('login')
                ->type('email', 'support@spondonit.com')
                ->type('password', '12345678')
                ->click(' div.login_wrapper > div.login_wrapper_left > div.login_wrapper_content > form > div > div:nth-child(5) > button')
                ->waitForText('Welcome To')
                ->assertSee('Welcome To');

        });
    }


    public function testTeacherSuccessfulLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('logout')
                ->visitRoute('login')
                ->type('email', 'teacher@infixedu.com')
                ->type('password', '12345678')
                ->click(' div.login_wrapper > div.login_wrapper_left > div.login_wrapper_content > form > div > div:nth-child(5) > button')
                ->waitForText('Welcome To')
                ->assertSee('Welcome To');

        });
    }
    public function testStudentSuccessfulLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visitRoute('logout')
                ->visitRoute('login')
                ->type('email', 'student@infixedu.com')
                ->type('password', '12345678')
                ->click(' div.login_wrapper > div.login_wrapper_left > div.login_wrapper_content > form > div > div:nth-child(5) > button')
                ->waitForText('Recommended For You')
                ->assertSee('Recommended For You');

        });
    }
}
