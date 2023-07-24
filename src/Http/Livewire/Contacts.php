<?php

namespace LaraZeus\Wind\Http\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Contacts extends Component
{
    public ?string $departmentSlug;

    public function mount(string $departmentSlug = null): void
    {
        $this->departmentSlug = $departmentSlug;
    }

    public function render(): View | Application | Factory | \Illuminate\Contracts\Foundation\Application
    {
        seo()
            ->site(config('app.name', 'Laravel'))
            ->title(config('zeus.site_title'))
            ->description(config('zeus.site_description'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-wind.color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('windTheme') . '.contact')
            ->layout(config('zeus.layout'));
    }
}
