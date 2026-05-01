<?php

namespace App\Listeners;

use App\Events\PackageSent;
use Illuminate\Support\Facades\Log;

class PackageListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PackageSent $event): void
    {
        Log::info("Event Package Sent: {$event->status} for room {$event->ruang}, bed {$event->bed}");

    }
}
