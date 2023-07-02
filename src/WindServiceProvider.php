<?php

namespace LaraZeus\Wind;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use LaraZeus\Wind\Console\PublishCommand;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;
use LaraZeus\Wind\Filament\Resources\LetterResource;
use LaraZeus\Wind\Http\Livewire\Contacts;
use LaraZeus\Wind\Http\Livewire\ContactsForm;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

class WindServiceProvider extends PluginServiceProvider
{
    public static string $name = 'zeus-wind';

    protected array $resources = [
        DepartmentResource::class,
        LetterResource::class,
    ];

    public function bootingPackage(): void
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
    }

    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
        ];
    }

    public function packageConfiguring(Package $package): void
    {
        $package
            ->hasMigrations([
                'create_department_table',
                'create_letters_table',
                'alter_letters_constraints',
            ])
            ->hasRoute('web');
    }
}
