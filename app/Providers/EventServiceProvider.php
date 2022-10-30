<?php

namespace App\Providers;

use App\Events\CreateMovementEvent;
use App\Events\CreateScheduleEvent;
use App\Events\CreateTicketEvent;
use App\Events\CreateWorkSheetEvent;
use App\Listeners\CreateMovementListener;
use App\Listeners\CreateScheduleListener;
use App\Listeners\CreateTicketListener;
use App\Listeners\CreateWorkSheetListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            // SendEmailVerificationNotification::class,
        ],
        CreateTicketEvent::class => [
            // CreateTicketListener::class,
        ],
        CreateWorkSheetEvent::class => [
            // CreateWorkSheetListener::class,
        ],
        CreateMovementEvent::class => [
            // CreateMovementListener::class,
        ],
        CreateScheduleEvent::class => [
            // CreateScheduleListener::class,
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

        //
    }
}
