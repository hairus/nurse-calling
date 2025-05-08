<?php

namespace App\Providers;

use App\Events\PackageSent;
use App\Listeners\PackageListener;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $listen = [
        PackageSent::class => [
            PackageListener::class,
        ],
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // parent::boot();
    }
}
