<?php

namespace App\Listeners;

use App\Events\CreatePassengerEvent;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CreatePassengerListener
{

    public function handle(CreatePassengerEvent $event)
    {
        // init user
        $user = new User();

        $event->passenger->user_role = $event->role;
        $event->passenger->access_key = Str::random(10);

        unset($event->passenger->created_at);
        unset($event->passenger->updated_at);

        foreach ($event->passenger as $key => $value) {
            $user->$key = $value;
        }

        try {
            $user->save();
            $user->notify(new \App\Notifications\GetAccessKeyNotification($user->access_key));
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
}
