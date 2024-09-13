<?php

namespace App\Providers;

use App\Events\LastActivityEvent;
use App\Events\OneToOneConnection;
use App\Listeners\LastActivityListener;
use App\Listeners\ListenOneToOneConnection;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Group\Listeners\GroupMemberCreateListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OneToOneConnection::class => [
            ListenOneToOneConnection::class,
        ], LastActivityEvent::class => [
            LastActivityListener::class,
        ],  GroupMemberCreate::class =>[
            GroupMemberCreateListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
