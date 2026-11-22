<?php

namespace LaraZeus\Wind;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use LaraZeus\FilamentPluginTools\Concerns\HasResources;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;
use LaraZeus\Wind\Filament\Resources\LetterResource;

final class WindPlugin implements Plugin
{
    use Configuration;
    use EvaluatesClosures;
    use HasResources;

    public function getId(): string
    {
        return 'zeus-wind';
    }

    public function register(Panel $panel): void
    {
        if ($this->hasDepartmentResource()) {
            $panel->resources([
                $this->resolveResource('Department') ?? DepartmentResource::class,
            ]);
        }

        $panel
            ->resources([
                $this->resolveResource('Letter') ?? LetterResource::class,
            ]);
    }

    public static function make(): static
    {
        return new self;
    }

    public static function get(): static
    {
        // @phpstan-ignore-next-line
        return filament('zeus-wind');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
