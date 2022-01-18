<?php

namespace App\Providers;

use App\Providers\CreatePassengerEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreatePassengerListener
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
     * @param  \App\Providers\CreatePassengerEvent  $event
     * @return void
     */
    public function handle(CreatePassengerEvent $event)
    {
        //
    }
}
