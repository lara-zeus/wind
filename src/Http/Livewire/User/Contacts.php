<?php

namespace LaraZeus\Wind\Http\Livewire\User;

use Livewire\Component;

class Contacts extends Component
{
    public function render()
    {
        return view('wind::contact')->layout(config('zeus.wind.layout'));
    }
}