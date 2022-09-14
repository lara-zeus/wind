<?php

namespace LaraZeus\Wind\Filament\Resources\LetterResource\Pages;

use Filament\Resources\Pages\EditRecord;
use LaraZeus\Wind\Filament\Resources\LetterResource;

class EditLetter extends EditRecord
{
    protected static string $resource = LetterResource::class;

    public function mount($record): void
    {
        parent::mount($record);
        
        if (strtoupper($this->record->status) === config('zeus-wind.default_status')) {
            $this->record->update(['status' => 'READ']);
        }
    }

    protected function afterSave(): void
    {
        if ($this->record->reply_message !== null) {
            $this->record->update(['status' => 'REPLIED']);
        }
    }
}
