<?php

namespace LaraZeus\Wind\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use LaraZeus\Wind\Filament\Resources\LetterResource\Pages;
use LaraZeus\Wind\Models\Category;
use LaraZeus\Wind\Models\Letter;

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
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Select::make('category_id')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(['sm' => 2]),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpan(['sm' => 2]),
                TextInput::make('reply_title')
                    ->default('re')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(['sm' => 2]),
                Forms\Components\Textarea::make('reply_message')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpan(['sm' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                ViewColumn::make('from')->view('zeus-wind::message-from')->sortable('name'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('status')->sortable(),
            ])
            ->defaultSort('id', 'desc');
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
