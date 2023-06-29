<?php

namespace LaraZeus\Wind;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use LaraZeus\Core\CoreServiceProvider;
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
        //CoreServiceProvider::setThemePath('wind');

        $viewPath = 'zeus::themes.'.config("zeus-wind.theme",'zeus').'.wind';
        View::share('windTheme', $viewPath);
        App::singleton('windTheme', function () use ($viewPath) {
            return $viewPath;
        });

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

    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
        ];
    }

    public function packageConfigured(Package $package): void
    {
        $package
            ->hasMigrations(['create_department_table', 'create_letters_table'])
            ->hasViews('zeus')
            ->hasRoute('web');
    }
}
