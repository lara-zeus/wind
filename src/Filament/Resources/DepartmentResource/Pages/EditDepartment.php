<?php

namespace LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;

class EditDepartment extends EditRecord
{
    protected static string $resource = DepartmentResource::class;

    public function mount(int|string $record): void
    {
        abort_unless(config('zeus-wind.enableDepartments'), 404);

        parent::mount($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Open')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->label(__('Open'))
                ->url(fn (): string => route('contact', ['departmentSlug' => $this->record]))
                ->openUrlInNewTab(),
        ];
    }
}
