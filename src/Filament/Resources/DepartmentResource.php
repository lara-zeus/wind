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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages;
use LaraZeus\Wind\Models\Department;

class DepartmentResource extends Resource
{
    public static function getModel(): string
    {
        return config('zeus-wind.models.department');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?int $navigationSort = 1;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function shouldRegisterNavigation(): bool
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
                    ->label(__('name'))
                    ->afterStateUpdated(function (Closure $set, $state, $context) {
                        if ($context === 'edit') {
                            return;
                        }

                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')->required()->maxLength(255)->label(__('slug')),
                TextInput::make('ordering')->required()->numeric()->label(__('ordering')),
                Toggle::make('is_active')->label(__('is_active')),
                Textarea::make('desc')->maxLength(65535)->columnSpan(['sm' => 2])->label(__('desc')),

                FileUpload::make('logo')
                    ->disk(config('zeus-wind.uploads.disk', 'public'))
                    ->directory(config('zeus-wind.uploads.dir', 'logos'))
                    ->columnSpan(['sm' => 2])
                    ->label(__('logo')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('name'))
                    ->sortable()
                    ->searchable()
                    ->url(fn (Department $record): string => route('contact', ['departmentSlug' => $record]))
                    ->openUrlInNewTab(),
                TextColumn::make('desc')->label(__('desc')),
                TextColumn::make('ordering')->sortable()->label(__('ordering')),
                IconColumn::make('is_active')->boolean()->sortable()->label(__('is_active')),
                ImageColumn::make('logo')->disk(config('zeus-wind.uploads.disk', 'public'))->label(__('logo')),
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

    public static function getLabel(): string
    {
        return __('Department');
    }

    public static function getPluralLabel(): string
    {
        return __('Departments');
    }

    protected static function getNavigationLabel(): string
    {
        return __('Departments');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Wind');
    }
}
