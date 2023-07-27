<?php

namespace LaraZeus\Wind\Filament\Resources\LetterResource\Pages;

use Filament\Resources\Pages\EditRecord;
use LaraZeus\Wind\Filament\Resources\LetterResource;
use LaraZeus\Wind\WindPlugin;

/**
 * @property mixed $record
 */
class EditLetter extends EditRecord
{
    protected static string $resource = LetterResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        if ($this->record->reply_message !== null && strtoupper($this->record->status) === WindPlugin::get()->getDefaultStatus()) {
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
