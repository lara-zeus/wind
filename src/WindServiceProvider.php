<?php

namespace LaraZeus\Wind;

use LaraZeus\Wind\Commands\PublishCommand;
use LaraZeus\Core\CoreServiceProvider;
use LaraZeus\Wind\Http\Livewire\Contacts;
use LaraZeus\Wind\Http\Livewire\ContactsForm;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WindServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('zeus-wind')
            ->hasMigrations($this->getMigrations())
            ->hasViews('zeus')
            ->hasRoute('web')
            ->hasCommands($this->getCommands());
    }

    public function bootingPackage(): void
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
