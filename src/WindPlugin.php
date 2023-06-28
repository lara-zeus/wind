<?php

namespace LaraZeus\Wind;

use Filament\Contracts\Plugin;
use Filament\Panel;
use LaraZeus\Wind\Commands\PublishCommand;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;
use LaraZeus\Wind\Filament\Resources\LetterResource;


use Filament\Facades\Filament;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\AssetManager;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\Icon;
use Filament\Support\Icons\IconManager;
use Illuminate\Filesystem\Filesystem;
use Livewire\Testing\TestableLivewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WindPlugin implements Plugin
{
    public static string $name = 'zeus-wind';

    public function getId(): string
    {
        return 'zeus-wind';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                DepartmentResource::class,
                LetterResource::class,
            ])
            ->pages([
                //
            ]);
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function boot(Panel $panel): void
    {
        //
    }




    /*public function bootingPackage(): void
    {
        Livewire::component('contact', Contacts::class);
        Livewire::component('contact-form', ContactsForm::class);

        View::share('', 'wind-theme::themes.' . config('zeus-wind.theme', 'zeus'));

        App::singleton('wind-theme', function () {
            return 'zeus-wind::themes.' . config('zeus-wind.theme', 'zeus');
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/seeders' => database_path('seeders'),
            ], 'zeus-wind-seeder');

            $this->publishes([
                __DIR__ . '/../database/factories' => database_path('factories'),
            ], 'zeus-wind-factories');
        }
    }*/

    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
        ];
    }

    public function packageConfiguring(Package $package): void
    {
        $package
            ->hasMigrations(['create_department_table', 'create_letters_table'])
            ->hasRoute('web');
    }

    public function configurePackage(Package $package): void
    {
        // TODO: Implement configurePackage() method.
    }
}
