<?php

namespace LaraZeus\Wind\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;
use LaraZeus\Wind\Filament\Resources\CategoryResource\Pages;
use LaraZeus\Wind\Models\Category;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Wind';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ordering')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\Textarea::make('desc')
                    ->maxLength(65535)
                    ->columnSpan([
                        'sm' => 2,
                        'xl' => 2,
                        '2xl' => 2,
                    ]),

                FileUpload::make('logo')
                    ->columnSpan([
                        'sm' => 2,
                        'xl' => 2,
                        '2xl' => 2,
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->url(fn(Category $record): string => route('contact', ['category' => $record]))
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('desc'),
                Tables\Columns\TextColumn::make('ordering'),
                Tables\Columns\BooleanColumn::make('is_active'),
                ImageColumn::make('logo'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}