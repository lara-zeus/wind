<?php

namespace LaraZeus\Wind;

use Illuminate\Support\ServiceProvider;
use LaraZeus\Wind\Console\InstallCommand;
use LaraZeus\Wind\Http\Livewire\Admin\Categories;
use LaraZeus\Wind\Http\Livewire\Admin\Letters;
use LaraZeus\Wind\Http\Livewire\Admin\Reply;
use LaraZeus\Wind\Http\Livewire\User\ContactsForm;
use Livewire\Livewire;
use Validator;

class WindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'wind');

        Livewire::component('categories', Categories::class);
        Livewire::component('letters', Letters::class);
        Livewire::component('wind-contact-form', ContactsForm::class);
        Livewire::component('reply', Reply::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('zeus/wind.php'),
            ], 'wind-config');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'wind-migrations');

            $this->publishes([
                __DIR__.'/../database/seeders' => database_path('seeders'),
            ], 'wind-seeder');

            $this->publishes([
                __DIR__.'/../database/factories' => database_path('factories'),
            ], 'wind-factories');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/wind'),
            ], 'wind-views');
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'zeus');

        $this->app->singleton('wind', function () {
            return new Wind;
        });
    }
}