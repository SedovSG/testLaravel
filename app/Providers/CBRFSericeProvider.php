<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CBRF\CBRFSerivce;
use App\Services\CBRF\SerivceInterface;

class CBRFSericeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SerivceInterface::class, CBRFSerivce::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
