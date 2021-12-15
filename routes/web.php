<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Wind\Http\Livewire\Admin\Categories;
use LaraZeus\Wind\Http\Livewire\Admin\Reply;
use LaraZeus\Wind\Http\Livewire\Admin\Letters;
use LaraZeus\Wind\Http\Livewire\User\Contacts;

Route::prefix(config('zeus.wind.path'))->name('wind.')->middleware('web')->group(function () {
    Route::prefix(config('zeus.wind.user.prefix'))->name('user.')->middleware(config('zeus.wind.user.middleware'))->group(function () {
        Route::get('contact', Contacts::class)->name('contact');
    });

    Route::prefix(config('zeus.wind.admin.prefix'))->name('admin.')->middleware(config('zeus.wind.admin.middleware'))->group(function () {
        Route::get('categories', Categories::class)->name('categories');
        Route::get('letters', Letters::class)->name('letters');
        Route::get('reply/{id}', Reply::class)->name('letter.reply');
    });
});