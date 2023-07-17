<?php

namespace LaraZeus\Wind\Http\Livewire;

use Livewire\Component;

class Contacts extends Component
{
    public ?string $departmentSlug;

    public function mount(string $departmentSlug = null): void
    {
        $this->departmentSlug = $departmentSlug;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        seo()
            ->site(config('app.name', 'Laravel'))
            ->title(config('zeus-wind.site_title'))
            ->description(config('zeus-wind.site_description'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-wind.color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('wind-theme') . '.contact')
            ->layout(config('zeus-wind.layout'));
    }
}
