<?php

namespace LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    public function mount(): void
    {
        abort_unless(config('zeus-wind.enableDepartments'), 404);

        parent::mount();
    }
}
