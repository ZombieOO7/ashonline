<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLastSigningAt
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
     * @param Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        if ($event->guard == "parent") {
            $event->user->last_sign_in_at = $event->user->current_sign_in_at ? $event->user->current_sign_in_at : Carbon::now();
            $event->user->current_sign_in_at = Carbon::now();
            if ($event->user->status == 2) {
                $status = 1;
                $event->user->status = $status ? $status : 1;
            }
            $event->user->save();
        }
    }
}
