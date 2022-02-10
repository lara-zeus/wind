<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Wind\Http\Livewire\Contacts;

Route::middleware(config('zeus.middleware'))
    ->prefix(config('zeus.prefix'))
    ->get('contact-us/{department?}', Contacts::class)
    ->name('contact');
