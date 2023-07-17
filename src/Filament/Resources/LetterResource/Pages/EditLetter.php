<?php

namespace LaraZeus\Wind\Filament\Resources\LetterResource\Pages;

use Filament\Resources\Pages\EditRecord;
use LaraZeus\Wind\Filament\Resources\LetterResource;

class EditLetter extends EditRecord
{
    protected static string $resource = LetterResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        // @phpstan-ignore-next-line
        if (strtoupper($this->record->status) === config('zeus-wind.default_status')) {
            $this->record->update(['status' => 'READ']);
        }
    }

    protected function afterSave(): void
    {
        // @phpstan-ignore-next-line
        if ($this->record->reply_message !== null) {
            $this->record->update(['status' => 'REPLIED']);
        }
    }
}
