<?php

namespace LaraZeus\Wind\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use LaraZeus\Wind\Filament\Resources\LetterResource\Pages;
use LaraZeus\Wind\Models\Department;
use LaraZeus\Wind\Models\Letter;

class LetterResource extends Resource
{
    protected static ?string $model = Letter::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?int $navigationSort = 2;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', config('zeus-wind.default_status'))->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('name'))
                    ->required()
                    ->disabled()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('email'))
                    ->email()
                    ->required()
                    ->disabled()
                    ->maxLength(255),
                Select::make('department_id')
                    ->label(__('department'))
                    ->options(Department::all()->pluck('name', 'id'))
                    ->required()
                    ->visible(fn (): bool => config('zeus-wind.enableDepartments')),
                TextInput::make('status')
                    ->label(__('status'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('title')
                    ->label(__('title'))
                    ->required()
                    ->disabled()
                    ->maxLength(255)
                    ->columnSpan(['sm' => 2]),
                Textarea::make('message')
                    ->label(__('message'))
                    ->disabled()
                    ->maxLength(65535)
                    ->columnSpan(['sm' => 2]),
                TextInput::make('reply_title')
                    ->label(__('reply_title'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(['sm' => 2]),
                Textarea::make('reply_message')
                    ->label(__('reply_message'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpan(['sm' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('from')->view('zeus-wind::filament.message-from')->sortable(['name'])->label(__('from')),
                TextColumn::make('title')->sortable()->label(__('title')),
                TextColumn::make('department.name')->sortable()->visible(fn (): bool => config('zeus-wind.enableDepartments'))->label(__('department')),
                TextColumn::make('status')->sortable()->label(__('status'))
                    ->formatStateUsing(fn (string $state): string => __("status_{$state}")),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLetters::route('/'),
            'edit' => Pages\EditLetter::route('/{record}/edit'),
        ];
    }

    public static function getLabel() : string
    {
        return __('Letter');
    }

    public static function getPluralLabel() : string
    {
        return __('Letters');
    }

    protected static function getNavigationLabel() : string
    {
        return __('Letters');
    }

    protected static function getNavigationGroup() : ?string
    {
        return __('Wind');
    }
}
