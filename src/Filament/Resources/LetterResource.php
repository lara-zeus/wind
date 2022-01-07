<?php

namespace LaraZeus\Wind\Filament\Resources;

use Filament\Tables\Actions\IconButtonAction;
use LaraZeus\Wind\Events\ReplySent;
use LaraZeus\Wind\Filament\Resources\LetterResource\Pages;
use LaraZeus\Wind\Models\Letter;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;

class LetterResource extends Resource
{
    protected static ?string $model = Letter::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Wind';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('category_id')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                /*Forms\Components\Textarea::make('message')
                    ->required()
                    ->maxLength(65535),*/

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('from')->view('zeus-wind::message-from'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                IconButtonAction::make('reply')
                    ->action(function (Letter $record, array $data): void {
                        $record->reply_title = __('re:').$record->title;
                        $record->reply_message = $data['reply_message'];
                        $record->status = 'REPLIED';
                        $record->save();

                        ReplySent::dispatch($record);
                    })
                    ->form([
                        Forms\Components\Textarea::make('reply_message')
                            ->required()
                            ->maxLength(65535),
                    ])
                    ->color('success')
                    ->icon('heroicon-o-reply')
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLetters::route('/'),
            'create' => Pages\CreateLetter::route('/create'),
            'edit' => Pages\EditLetter::route('/{record}/edit'),
        ];
    }
}