<?php

namespace App\Listeners;

use App\Events\LastLoginEvent;
use Illuminate\Support\Facades\DB;

class LastLoginListener
{
    public function handle(LastLoginEvent $event)
    {
        $user = $event->user;

        // Update last_login di database
        DB::table('readers')
            ->where('id', $user->id)
            ->update(['last_login' => now()]);
    }
}
