<?php

namespace LaraZeus\Wind;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use LaraZeus\Wind\Commands\PublishCommand;
use LaraZeus\Wind\Http\Livewire\Contacts;
use LaraZeus\Wind\Http\Livewire\ContactsForm;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WindServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-wind';

    public static string $viewNamespace = 'zeus-wind';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasRoute('web')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('lara-zeus/wind');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function bootingPackage(): void
    {
        Livewire::component('contact', Contacts::class);
        Livewire::component('contact-form', ContactsForm::class);

        View::share('wind-theme', 'wind-theme::themes.' . config('zeus-wind.theme', 'zeus'));

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

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_department_table',
            'create_letters_table',
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
        ];
    }
}
