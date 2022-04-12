<?php

namespace LaraZeus\Wind;

use Filament\PluginServiceProvider;
use LaraZeus\Wind\Console\PublishCommand;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;
use LaraZeus\Wind\Filament\Resources\LetterResource;
use LaraZeus\Wind\Http\Livewire\Contacts;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

class WindServiceProvider extends PluginServiceProvider
{
    public static string $name = 'zeus-wind';

    protected function getResources(): array
    {
        return [
            DepartmentResource::class,
            LetterResource::class,
        ];
    }

    public function boot()
    {
        Livewire::component('contact', Contacts::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/seeders' => database_path('seeders'),
            ], 'zeus-wind-seeder');

            $this->publishes([
                __DIR__.'/../database/factories' => database_path('factories'),
            ], 'zeus-wind-factories');
        }

        return parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        parent::configurePackage($package);
        $package
            ->hasConfigFile()
            ->hasMigrations(['create_department_table', 'create_letters_table'])
            ->hasCommand(PublishCommand::class)
            ->hasRoute('web');
    }
}
