<?php

namespace LaraZeus\Wind;

use Filament\Contracts\Plugin;
use Filament\Panel;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;
use LaraZeus\Wind\Filament\Resources\LetterResource;

class WindPlugin implements Plugin
{
    public function getId(): string
    {
        return 'zeus-wind';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                DepartmentResource::class,
                LetterResource::class,
            ]);
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
