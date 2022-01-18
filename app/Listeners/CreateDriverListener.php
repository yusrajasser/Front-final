<?php

namespace App\Listeners;

use App\Events\CreateDriverEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateDriverListener
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
     * @param  \App\Events\CreateDriverEvent  $event
     * @return void
     */
    public function handle(CreateDriverEvent $event)
    {
        //
    }
}
