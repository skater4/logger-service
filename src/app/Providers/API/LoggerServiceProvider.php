<?php

namespace App\Providers\API;

use App\Services\Logger\CsvLogger;
use App\Services\Logger\Interfaces\LoggerInterface;
use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LoggerInterface::class, CsvLogger::class);
    }
}
