<?php

namespace App\Listeners;

use App\Events\CreateAdminEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateAdminListener
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
     * @param  \App\Events\CreateAdminEvent  $event
     * @return void
     */
    public function handle(CreateAdminEvent $event)
    {
        //
    }
}
