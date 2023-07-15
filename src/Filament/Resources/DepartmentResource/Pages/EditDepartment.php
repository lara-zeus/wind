<?php

namespace LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;
use LaraZeus\Wind\Filament\Resources\DepartmentResource;

class EditDepartment extends EditRecord
{
    protected static string $resource = DepartmentResource::class;

    public function mount($record): void /* @phpstan-ignore-line */
    {
        abort_unless(config('zeus-wind.enableDepartments'), 404);

        parent::mount($record);
    }

    protected function getActions(): array
    {
        return array_merge(
            parent::getActions(),
            [
                Action::make('Open')
                    ->color('warning')
                    ->icon('heroicon-o-external-link')
                    ->label(__('Open'))
                    ->url(fn (): string => route('contact', ['departmentSlug' => $this->record]))
                    ->openUrlInNewTab(),
            ],
        );
    }
}
