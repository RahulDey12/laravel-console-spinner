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

        Command::macro(
            'spinner',
            function (int $max = 0) {
                return new Spinner($this->output, $max);
            }
        );

        Command::macro(
            'withSpinner',
            function ($totalSteps, \Closure $callback, string $message = '') {
                $spinner = $this->spinner(
                    is_iterable($totalSteps) ? count($totalSteps) : $totalSteps
                );
                $spinner->setMessage($message);
                $spinner->start();

                if (is_iterable($totalSteps)) {
                    foreach ($totalSteps as $item) {
                        $callback($item, $spinner);

                        $spinner->advance();
                    }
                } else {
                    $callback($spinner);
                }

                $spinner->finish();

                if (is_iterable($spinner)) {
                    return $totalSteps;
                }
            }
        );
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/console-spinner.php',
            'console-spinner'
        );
    }
}
