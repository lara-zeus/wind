<?php

namespace LaraZeus\Wind\Filament\Resources;

use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages;
use LaraZeus\Wind\Models\Department;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Wind';

    protected static function shouldRegisterNavigation() : bool
    {
        return config('zeus-wind.enableDepartments');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')->required()->maxLength(255),
                TextInput::make('ordering')->required()->numeric(),
                Toggle::make('is_active')->required(),
                Textarea::make('desc')->maxLength(65535)->columnSpan(['sm' => 2]),

                FileUpload::make('logo')
                    ->disk(config('zeus-wind.uploads.disk', 'public'))
                    ->directory(config('zeus-wind.uploads.dir', 'logos'))
                    ->columnSpan(['sm' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->url(fn (Department $record): string => route('contact', ['department' => $record]))
                    ->openUrlInNewTab(),
                TextColumn::make('desc'),
                TextColumn::make('ordering')->sortable(),
                BooleanColumn::make('is_active')->sortable(),
                ImageColumn::make('logo')->disk(config('zeus-wind.uploads.disk', 'public')),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
