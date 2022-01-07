<?php

namespace LaraZeus\Wind;

use Filament\PluginServiceProvider;
use LaraZeus\Wind\Filament\Resources\CategoryResource;
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
            CategoryResource::class,
            LetterResource::class,
        ];
    }

    public function boot()
    {
        Livewire::component('contact', Contacts::class);

        return parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        parent::configurePackage($package);
        $package
            ->hasConfigFile()
            ->hasMigrations(['create_category_table', 'create_letters_table'])
            ->hasRoute('web');
    }
}