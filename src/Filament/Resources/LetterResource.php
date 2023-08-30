<?php

namespace LaraZeus\Wind\Filament\Resources;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaraZeus\Wind\Filament\Resources\LetterResource\Pages;
use LaraZeus\Wind\Models\Letter;
use LaraZeus\Wind\WindPlugin;

class LetterResource extends Resource
{
    public static function getModel(): string
    {
        return WindPlugin::get()->getLetterModel();
    }

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', WindPlugin::get()->getDefaultStatus())->count();
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

                Section::make()
                    ->schema([
                        Placeholder::make('sender_info')
                            ->label('Sender Info:')
                            ->columnSpan(['sm' => 2]),

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

                        TextInput::make('title')
                            ->label(__('title'))
                            ->required()
                            ->disabled()
                            ->maxLength(255),

                        TextInput::make('created_at')
                            ->label(__('sent at'))
                            ->disabled(),

                        Textarea::make('message')
                            ->label(__('message'))
                            ->disabled()
                            ->maxLength(65535)
                            ->columnSpan(['sm' => 2]),
                    ])
                    ->columns(2),

                Section::make()
                    ->schema([
                        Select::make('department_id')
                            ->label(__('department'))
                            ->options(WindPlugin::get()->getDepartmentModel()::pluck('name', 'id'))
                            ->required()
                            ->visible(fn (): bool => WindPlugin::get()->hasDepartmentResource()),
                        TextInput::make('status')
                            ->label(__('status'))
                            ->required()
                            ->maxLength(255),

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
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('avatar')
                        ->getStateUsing(fn (
                            $record
                        ) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=FFFFFF&background=111827')
                        ->toggleable()
                        ->circular()
                        ->grow(false),
                    Stack::make([
                        TextColumn::make('name')
                            ->weight('bold')
                            ->toggleable()
                            ->searchable()
                            ->limit(20)
                            ->sortable(),
                        TextColumn::make('email')
                            ->limit(20),
                    ]),
                    Stack::make([
                        TextColumn::make('title')
                            ->sortable()
                            ->searchable()
                            ->toggleable()
                            ->label(__('title')),
                        TextColumn::make('department.name')
                            ->sortable()
                            ->badge()
                            ->searchable()
                            ->toggleable()
                            ->visible(fn (): bool => WindPlugin::get()->hasDepartmentResource())
                            ->label(__('department')),
                    ]),

                    Stack::make([
                        TextColumn::make('created_at')
                            ->sortable()
                            ->searchable()
                            ->toggleable()
                            ->dateTime()
                            ->label(__('sent at')),
                        TextColumn::make('status')
                            ->formatStateUsing(fn (string $state): string => __("status_{$state}"))
                            ->label(__('status'))
                            ->sortable()
                            ->searchable()
                            ->toggleable()
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'NEW' => 'danger',
                                'REPLIED' => 'gray',
                                'READ' => 'success',
                                default => '',
                            }),
                    ]),
                ]),
            ])
            ->recordClasses(fn (Letter $record) => match ($record->status) {
                'NEW' => 'border-s-2 border-danger-600 dark:border-danger-300',
                'REPLIED' => 'border-s-2 border-gray-600 dark:border-gray-300',
                'READ' => 'border-s-2 border-success-600 dark:border-success-300',
                default => '',
            })
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
                    ->visible(fn (): bool => WindPlugin::get()->hasDepartmentResource())
                    ->options(WindPlugin::get()->getDepartmentModel()::pluck('name', 'id'))
                    ->label(__('department')),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make('edit')->label(__('Edit')),
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
        return WindPlugin::get()->getNavigationGroupLabel();
    }
}
