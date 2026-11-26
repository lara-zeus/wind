---
name: zeus-wind
description: Use when installing, configuring, or customizing the lara-zeus/wind contact form plugin, departments, letters, and events in Laravel/Filament.
---

# Lara Zeus Wind (`lara-zeus/wind`)

## Overview & Requirements
`lara-zeus/wind` provides a frontend Livewire contact form (`contact-form`) with optional departments and Filament resources to manage incoming letters and replies.
- **PHP**: `^8.2`
- **Dependencies**: `lara-zeus/core` (`^5.0`), `lara-zeus/filament-plugin-tools` (`^3.0.3`)

## Installation
```bash
composer require lara-zeus/wind
php artisan wind:publish
php artisan migrate
```
`php artisan wind:publish` (`--force` supported) publishes `zeus-wind-migrations`, `zeus-wind-translations`, `zeus-config`, `zeus-views`, and `zeus-assets`.

Optional seeders and factories:
```bash
php artisan vendor:publish --tag=zeus-wind-seeder
php artisan vendor:publish --tag=zeus-wind-factories
```

## Migrations
Published migrations from `WindServiceProvider`:
- `create_department_table`
- `create_letters_table`

## Filament Panel Registration & Configuration
Register `LaraZeus\Wind\WindPlugin` in your PanelProvider (e.g. `AdminPanelProvider`). Wind is configured on the plugin instance rather than a separate config file:
```php
use LaraZeus\Wind\Models\Department;
use LaraZeus\Wind\Models\Letter;
use LaraZeus\Wind\WindPlugin;

->plugins([
    WindPlugin::make()
        ->windPrefix('wind')
        ->windMiddleware(['web'])
        ->defaultDepartmentId(1)
        ->defaultStatus('NEW')
        ->departmentResource(true)
        ->windModels([
            'Department' => Department::class,
            'Letter' => Letter::class,
        ])
        ->uploadDisk('public')
        ->uploadDirectory('logos')
        ->navigationGroupLabel('Wind'),
])
```

## Core Usage
- **Frontend route**: `GET /{windPrefix}/{departmentSlug?}` named `contact` (renders `LaraZeus\Wind\Livewire\ContactsForm`).
- **Livewire embed**: `<livewire:contact-form />` (registered as `contact-form`).
- **Disable departments**: call `->departmentResource(false)` on `WindPlugin::make()`.
- **Events**:
  - `LaraZeus\Wind\Events\LetterSent` — dispatched when a visitor submits a letter via `ContactsForm::store()`.
  - `LaraZeus\Wind\Events\NewLetterSent` — dispatched when sending a new letter from the admin panel.
  - `LaraZeus\Wind\Events\ReplySent` — dispatched when replying to a letter from the admin panel.

## Common Pitfalls
- **Looking for `config/zeus-wind.php`**: Wind has no config file; panel/route options live on `WindPlugin` (`LaraZeus\Wind\Configuration`).
- **404 on `/wind`**: The `contact` route in `routes/web.php` checks `app('filament')->hasPlugin('zeus-wind')`; ensure `WindPlugin::make()` is registered on the active Filament panel.
- **Wrong model override method**: Use `->windModels([...])` on `WindPlugin` (not `->models([...])`).
