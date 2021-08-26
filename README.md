# Laravel Console Spinner
Laravel Console Spinner was created by [Rahul Dey](https://github.com/RahulDey12). It is just a custom Progress Bar inspired by [icanhazstring/symfony-console-spinner](https://github.com/icanhazstring/symfony-console-spinner).

## Installation
> **Requires [PHP 7.3+](https://php.net/releases/)**

Via [Composer](https://getcomposer.org):

```bash
composer require rahul900day/laravel-console-spinner
```

## Usage
```php
class SimpleLaravelCommand extends Command
{
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $spinner = $this->spinner($users->count());
        $spinner->setMessage('Loading...');
        $spinner->start();
        
        foreach ($users as $user) {
            // Do your stuff...
            
            $spinner->advance();
        }
        $spinner->finish();
    }
}
```
The `$spinner` is compatible with Symfony `ProgressBar`, so you can run any method of this class.

Or you can also use with `withSpinner` method by giving an iterable.
```php
$this->withSpinner(User::all(), function($user) {
    // Do your stuff with $user
}, 'Loading...');
```

## Licence
This package is released under the [MIT license](https://github.com/RahulDey12/laravel-console-spinner/blob/master/LICENSE).