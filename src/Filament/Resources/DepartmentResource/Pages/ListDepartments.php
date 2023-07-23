<?php

namespace LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
