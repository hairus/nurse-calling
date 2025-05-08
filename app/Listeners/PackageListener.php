<?php

namespace App\Listeners;

use App\Events\PackageSent;
use App\Events\PackgeListener;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
        Log::info("Event Package Sent: {$event->status} for room {$event->room}, bed {$event->bed}");

    }
}
