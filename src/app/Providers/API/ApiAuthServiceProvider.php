<?php

namespace App\Providers\API;

use App\Services\ApiAuth\Interfaces\ApiAuthInterface;
use App\Services\ApiAuth\TokenAuth;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Foundation\Application;

class ApiAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ApiAuthInterface::class, function (Application $app) {
            return new TokenAuth(
                $app['config']['auth']['api_token']
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
