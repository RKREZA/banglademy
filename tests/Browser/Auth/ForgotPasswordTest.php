<?php

namespace Tests\Browser\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForgotPasswordTest extends DuskTestCase
{
    public function testVisitPageFromLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->click('.forgot_pass')
                ->waitForText('Reset Password')
                ->assertSee('Reset Password');
        });
    }

    public function testEmptyEmail()
    {

        $this->browse(function ($browser) {
            $browser->visitRoute('password.request')
                ->click('div.login_wrapper > div.login_wrapper_left > div.login_wrapper_content > form > div > div:nth-child(2) > button')
                ->assertSee('This Value Field Is Required');
        });

    }

    public function testInvalidEmail()
    {

        $this->browse(function ($browser) {
            $browser->visitRoute('password.request')
                ->type('email', 'spn19@notemail.com')
                ->click('div.login_wrapper > div.login_wrapper_left > div.login_wrapper_content > form > div > div:nth-child(2) > button')
                ->waitForText('We can\'t find a user with that email address.')
                ->assertSee('We can\'t find a user with that email address.');
        });

    }



    public function testBackToLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('password.request')
                ->click('div.login_wrapper > div.login_wrapper_left > h5 > a')
                ->assertSee('Register');
        });
    }
}
