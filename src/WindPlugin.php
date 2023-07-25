<?php

namespace LaraZeus\Wind;

use Filament\Contracts\Plugin;
use Filament\Panel;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;
use LaraZeus\Wind\Filament\Resources\LetterResource;

class WindPlugin implements Plugin
{
    use Configuration;

    public function getId(): string
    {
        return 'zeus-wind';
    }

    public function register(Panel $panel): void
    {
        if ($this->hasDepartmentResource()) {
            $panel->resources([
                DepartmentResource::class,
            ]);
        }

        $panel
            ->resources([
                LetterResource::class,
            ]);
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): Plugin | \Filament\FilamentManager
    {
        return filament(app(static::class)->getId());
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
