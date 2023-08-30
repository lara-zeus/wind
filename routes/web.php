<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Wind\Livewire\ContactsForm;
use LaraZeus\Wind\WindPlugin;

if (app('filament')->hasPlugin('zeus-wind')) {
    Route::middleware(WindPlugin::get()->getMiddleware())
        ->prefix(WindPlugin::get()->getWindPrefix())
        ->get('{departmentSlug?}', ContactsForm::class)
        ->name('contact');
}
