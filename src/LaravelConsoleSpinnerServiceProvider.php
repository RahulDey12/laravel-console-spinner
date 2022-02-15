<?php

namespace Rahul900Day\LaravelConsoleSpinner;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Console\Command;

class LaravelConsoleSpinnerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/console-spinner.php' => config_path('console-spinner.php'),
        ], 'console-spinner-config');

        Command::mixin(new SpinnerMixin());
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/console-spinner.php',
            'console-spinner'
        );
    }
}
