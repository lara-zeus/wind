<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Wind\Http\Livewire\Contacts;

Route::middleware(config('zeus.user.middleware'))
    ->get('contact-us/{category?}', Contacts::class)
    ->name('contact');