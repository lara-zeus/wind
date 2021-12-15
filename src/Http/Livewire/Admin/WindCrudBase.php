<?php

namespace LaraZeus\Wind\Http\Livewire\Admin;

use LaraZeus\Core\Http\Livewire\Crud\CrudBase;

class WindCrudBase extends CrudBase
{
    public function render()
    {
        return view('zeus::crud.base')
            ->layout('zeus::components.layouts.app')
            ->with('rows', $this->rows);
    }
}