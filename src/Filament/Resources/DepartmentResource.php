<?php

namespace LaraZeus\Wind\Filament\Resources;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages\CreateDepartment;
use LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages\EditDepartment;
use LaraZeus\Wind\Filament\Resources\DepartmentResource\Pages\ListDepartments;
use LaraZeus\Wind\Models\Department;
use LaraZeus\Wind\WindPlugin;

class DepartmentResource extends Resource
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?int $navigationSort = 1;

    public static function getModel(): string
    {
        return WindPlugin::get()->getModel('Department');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->label(__('zeus-wind::wind.name'))
                    ->afterStateUpdated(function (Set $set, $state, $context) {
                        if ($context === 'edit') {
                            return;
                        }

                        $set('slug', str()->slug($state));
                    }),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->label(__('zeus-wind::wind.slug')),

                TextInput::make('ordering')
                    ->required()
                    ->numeric()
                    ->label(__('zeus-wind::wind.ordering')),

                Toggle::make('is_active')
                    ->label(__('zeus-wind::wind.is_active')),

                Textarea::make('desc')
                    ->maxLength(65535)
                    ->columnSpan(['sm' => 2])
                    ->label(__('zeus-wind::wind.desc')),

                FileUpload::make('logo')
                    ->disk(WindPlugin::get()->getUploadDisk())
                    ->directory(WindPlugin::get()->getUploadDirectory())
                    ->columnSpan(['sm' => 2])
                    ->label(__('zeus-wind::wind.logo')),
            ]);
    }

    /**
     * @return Builder
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('zeus-wind::wind.name'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('desc')
                    ->searchable()
                    ->label(__('zeus-wind::wind.desc'))
                    ->toggleable(),
                TextColumn::make('ordering')
                    ->searchable()
                    ->sortable()
                    ->label(__('zeus-wind::wind.ordering'))
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->searchable()
                    ->sortable()
                    ->label(__('zeus-wind::wind.is_active'))
                    ->toggleable(),
                ImageColumn::make('logo')
                    ->disk(WindPlugin::get()->getUploadDisk())
                    ->label(__('zeus-wind::wind.logo'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                TrashedFilter::make(),
                Filter::make('is_active')
                    ->label(__('zeus-wind::wind.is_active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                Filter::make('not_active')
                    ->label(__('zeus-wind::wind.not_active'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false)),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make('edit')->label(__('zeus-wind::wind.edit')),
                    ViewAction::make('view')
                        ->color('primary')
                        ->label(__('zeus-wind::wind.view')),
                    Action::make('Open')
                        ->color('warning')
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->label(__('zeus-wind::wind.open'))
                        ->url(fn (Model $record): string => route('contact', ['departmentSlug' => $record]))
                        ->openUrlInNewTab(),
                    DeleteAction::make('delete'),
                    ForceDeleteAction::make(),
                    RestoreAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDepartments::route('/'),
            'create' => CreateDepartment::route('/create'),
            'edit' => EditDepartment::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('zeus-wind::wind.department_1');
    }

    public static function getPluralLabel(): string
    {
        return __('zeus-wind::wind.departments');
    }

    public static function getNavigationLabel(): string
    {
        return __('zeus-wind::wind.departments');
    }

    public static function getNavigationGroup(): ?string
    {
        return WindPlugin::get()->getNavigationGroupLabel();
    }
}
