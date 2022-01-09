<?php

namespace LaraZeus\Wind\Filament\Resources\CategoryResource\Pages;

use LaraZeus\Wind\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Wind\Models\Category;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;
}
