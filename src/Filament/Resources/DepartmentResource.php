<?php

namespace LaraZeus\Wind\Filament\Resources;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages;

class DepartmentResource extends Resource
{
    public static function getModel(): string
    {
        return config('zeus-wind.models.department');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function shouldRegisterNavigation(): bool
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
                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state, $context) {
                        if ($context === 'edit') {
                            return;
                        }

                        $set('slug', str()->slug($state));
                    }),

                TextInput::make('slug')->required()->maxLength(255)->label(__('slug')),
                TextInput::make('ordering')->required()->numeric()->label(__('ordering')),
                Toggle::make('is_active')->label(__('is active')),
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
                    ->toggleable(),
                TextColumn::make('desc')
                    ->searchable()
                    ->label(__('desc'))
                    ->toggleable(),
                TextColumn::make('ordering')
                    ->searchable()
                    ->sortable()
                    ->label(__('ordering'))
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->searchable()
                    ->sortable()
                    ->label(__('is active'))
                    ->toggleable(),
                ImageColumn::make('logo')
                    ->disk(config('zeus-wind.uploads.disk', 'public'))
                    ->label(__('logo'))
                    ->toggleable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Filter::make('is_active')
                    ->label(__('is active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                Filter::make('not_active')
                    ->label(__('not active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false)),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make('edit')->label(__('Edit')),
                    ViewAction::make('view')
                        ->color('primary')
                        ->label(__('View')),
                    Action::make('Open')
                        ->color('warning')
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->label(__('Open'))
                        ->url(fn (Model $record): string => route('contact', ['departmentSlug' => $record]))
                        ->openUrlInNewTab(),
                    DeleteAction::make('delete')
                        ->label(__('Delete')),
                ]),
            ]);
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

    public static function getNavigationLabel(): string
    {
        return __('Departments');
    }

    public static function getNavigationGroup(): ?string
    {
        return __(config('zeus-wind.navigation_group_label', __('Wind')));
    }
}
