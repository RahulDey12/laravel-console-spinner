<?php

namespace Rahul900Day\LaravelConsoleSpinner;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Console\Command;

class LaravelConsoleSpinnerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Command::macro(
            'spinner',
            function (int $max = 0) {
                return new Spinner($this->output, $max);
            }
        );
    }
}