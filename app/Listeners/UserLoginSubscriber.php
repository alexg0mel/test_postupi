<?php

namespace App\Listeners;

use App\Entity\User;
use App\UseCases\Users\ApiTokenServices;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoginSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        if ($user=$event->user) {
            $userTokenService = new ApiTokenServices($user);
            $userTokenService->GenerateNewToken();
        }

    }


    /**
     * @param  Dispatcher  $events
     */
    public static function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserLoginSubscriber@handle'
        );
    }
}
