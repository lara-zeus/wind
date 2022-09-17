<?php

namespace LaraZeus\Wind\Http\Livewire;

use Livewire\Component;

class Contacts extends Component
{
    public $departmentSlug = null;

    public function mount($departmentSlug = null)
    {
        $this->departmentSlug = $departmentSlug;
    }

    public function render()
    {
        seo()
            ->site(config('app.name', 'Laravel'))
            ->title(config('zeus-wind.site_title'))
            ->description(config('zeus-wind.site_description'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-wind.color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('wind-theme') . '.contact')->layout(config('zeus-wind.layout'));
    }
}
