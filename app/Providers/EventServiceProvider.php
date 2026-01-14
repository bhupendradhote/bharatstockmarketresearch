<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserChatMessageSent;
// use App\Listeners\CreateChatNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    // protected $listen = [
    //     // 🔥 User → Admin chat event
    //     // UserChatMessageSent::class => [
    //     //     CreateChatNotification::class,
    //     // ],
    // ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
