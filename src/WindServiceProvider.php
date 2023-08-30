<?php

namespace LaraZeus\Wind;

use LaraZeus\Core\CoreServiceProvider;
use LaraZeus\Wind\Commands\PublishCommand;
use LaraZeus\Wind\Livewire\Contacts;
use LaraZeus\Wind\Livewire\ContactsForm;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WindServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-wind';

    public function packageBooted(): void
    {
        CoreServiceProvider::setThemePath('wind');

        Livewire::component('contact', Contacts::class);
        Livewire::component('contact-form', ContactsForm::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/seeders' => database_path('seeders'),
            ], 'zeus-wind-seeder');

            $this->publishes([
                __DIR__ . '/../database/factories' => database_path('factories'),
            ], 'zeus-wind-factories');
        }
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasTranslations()
            ->hasMigrations($this->getMigrations())
            ->hasRoute('web')
            ->hasViews('zeus')
            ->hasCommands($this->getCommands());
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
