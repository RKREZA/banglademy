<?php

namespace Tests\Browser\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegTest extends DuskTestCase
{
    use WithFaker;

    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function testCheckRegUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('register')
                ->assertSee('Sign Up Details');
        });
    }

    public function testEmptyReg()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('register')
                ->type('name', $this->faker->name)
                ->type('email', $this->faker->email)
                ->type('phone', $this->faker->phoneNumber)
                ->type('password', 12345678)
                ->type('password_confirmation', 12345678)
                ->click('#submitBtn')
                ->pause(5000)
                ->assertSee('Verify Your Email Address');
        });
    }
}
