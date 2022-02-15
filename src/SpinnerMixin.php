<?php

namespace Rahul900Day\LaravelConsoleSpinner;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SpinnerMixin
{
    protected function spinner()
    {
        return function (int $max = 0) {
            return new Spinner($this->output, $max);
        };
    }

    protected function withSpinner()
    {
        return function ($totalSteps, \Closure $callback, string $message = '', array $options = []) {
            $spinner = $this->spinner(
                is_iterable($totalSteps) ? count($totalSteps) : $totalSteps
            );
            $spinner->setMessage($message);
    
            // Set more options
            foreach ($options as $option => $args) {
                $method = Str::startsWith($option, 'set') ? Str::camel($option) : 'set'.Str::studly($option);
                call_user_func_array([$spinner, $method], Arr::wrap($args));
            }
    
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
        };
    }
}
