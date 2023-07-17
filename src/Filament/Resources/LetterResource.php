<?php

namespace LaraZeus\Wind\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaraZeus\Wind\Filament\Resources\LetterResource\Pages;
use LaraZeus\Wind\Models\Letter;

class LetterResource extends Resource
{
    public static function getModel(): string
    {
        return config('zeus-wind.models.letter');
    }

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', config('zeus-wind.default_status'))->count();
    }

    /**
     * @return Builder<Letter>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
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
                    ->options(config('zeus-wind.models.department')::pluck('name', 'id'))
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
                ViewColumn::make('from')
                    ->view('zeus-wind::filament.message-from')
                    ->sortable(['name'])
                    ->searchable(['name', 'email'])
                    ->toggleable()
                    ->label(__('from')),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__('title')),
                TextColumn::make('department.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->visible(fn (): bool => config('zeus-wind.enableDepartments'))
                    ->label(__('department')),
                TextColumn::make('status')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__('status'))
                    ->formatStateUsing(fn (string $state): string => __("status_{$state}")),
            ])
            ->defaultSort('id', 'desc')
            ->bulkActions([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('status')
                    ->options([
                        'NEW' => __('NEW'),
                        'READ' => __('READ'),
                        'REPLIED' => __('REPLIED'),
                    ])
                    ->label(__('status')),
                SelectFilter::make('department_id')
                    ->visible(fn (): bool => config('zeus-wind.enableDepartments'))
                    ->options(config('zeus-wind.models.department')::pluck('name', 'id'))
                    ->label(__('department')),
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
                    DeleteAction::make('delete'),
                    ForceDeleteAction::make(),
                    RestoreAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLetters::route('/'),
            'edit' => Pages\EditLetter::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('Letter');
    }

    public static function getPluralLabel(): string
    {
        return __('Letters');
    }

    public static function getNavigationLabel(): string
    {
        return __('Letters');
    }

    public static function getNavigationGroup(): ?string
    {
        return __(config('zeus-wind.navigation_group_label', __('Wind')));
    }
}
