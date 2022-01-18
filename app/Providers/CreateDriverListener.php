<?php

namespace App\Providers;

use App\Providers\CreateDriverEvent;
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
     * @param  \App\Providers\CreateDriverEvent  $event
     * @return void
     */
    public function handle(CreateDriverEvent $event)
    {
        //
    }
}
