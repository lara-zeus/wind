## Lara Zeus Wind (`lara-zeus/wind`)

Lara Zeus Wind is a Filament v5 plugin and Livewire contact form package with optional department routing, file uploads/logos, admin inbox management, and lifecycle events.

### Key Classes & Components
- Plugin: `LaraZeus\Wind\WindPlugin` (ID: `zeus-wind`)
- Service provider: `LaraZeus\Wind\WindServiceProvider` (`$name = 'zeus-wind'`)
- Livewire component: `LaraZeus\Wind\Livewire\ContactsForm` (registered as `contact-form`)
- Filament resources: `LaraZeus\Wind\Filament\Resources\DepartmentResource`, `LaraZeus\Wind\Filament\Resources\LetterResource`
- Models: `LaraZeus\Wind\Models\Department`, `LaraZeus\Wind\Models\Letter`
- Events (`LaraZeus\Wind\Events\*`): `LetterSent`, `NewLetterSent`, `ReplySent`

### Rules & Anti-Patterns
- Register `WindPlugin::make()` on your Filament panel; `routes/web.php` only registers the `contact` route when `app('filament')->hasPlugin('zeus-wind')` is true.
- Configure Wind via fluent methods on `WindPlugin::make()` (`->windPrefix()`, `->windModels()`, `->departmentResource()`, etc.) — there is no `config/zeus-wind.php` file.
- Use `WindPlugin::get()->getModel('Department')` / `WindPlugin::get()->getModel('Letter')` instead of hardcoding model classes when overriding models via `->windModels([...])`.
