<?php

namespace LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages;

use Filament\Resources\Pages\EditRecord;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;

class EditDepartment extends EditRecord
{
    protected static string $resource = DepartmentResource::class;

    public function mount($record): void
    {
        abort_unless(config('zeus-wind.enableDepartments'), 404);
    }
}
