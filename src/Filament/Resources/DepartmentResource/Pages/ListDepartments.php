<?php

namespace LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;
use Filament\Actions;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    public function mount(): void
    {
        abort_unless(config('zeus-wind.enableDepartments'), 404);

        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
