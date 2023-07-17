<?php

namespace LaraZeus\Wind;

use Filament\Facades\Filament;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\AssetManager;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\Icon;
use Filament\Support\Icons\IconManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
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

        //$this->package
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

    public function packageRegistered(): void
    {
        // Context Registration
        $this->app->resolving('zeus-wind', function () {
            foreach ($this->getContexts() as $context) {
                Filament::registerContext($context);
            }
        });

        // Asset Registration
        $this->app->resolving(AssetManager::class, function () {
            FilamentAsset::register($this->getAssets(), $this->getAssetPackage());
            FilamentAsset::registerScriptData($this->getScriptData(), $this->getAssetPackage());
        });

        // Icon Registration
        $this->app->resolving(IconManager::class, function () {
            FilamentIcon::register($this->getIcons());
        });
    }

    protected function getAssetPackage(): ?string
    {
        return static::$name ?? null;
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // todo add from core
            Css::make('zeus-wind-styles', __DIR__ . '/../resources/dist/filament.css'),
            Js::make('zeus-wind-scripts', __DIR__ . '/../resources/dist/filament.js'),
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

    /**
     * @return array<string, Icon>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return ['web'];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
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
}
