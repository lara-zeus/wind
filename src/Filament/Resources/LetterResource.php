<?php

namespace LaraZeus\Wind\Filament\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use LaraZeus\Wind\Filament\Resources\LetterResource\Pages\CreateLetter;
use LaraZeus\Wind\Filament\Resources\LetterResource\Pages\EditLetter;
use LaraZeus\Wind\Filament\Resources\LetterResource\Pages\ListLetters;
use LaraZeus\Wind\Models\Letter;
use LaraZeus\Wind\WindPlugin;

class LetterResource extends Resource
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-inbox';

    protected static ?int $navigationSort = 2;

    public static function getModel(): string
    {
        return WindPlugin::get()->getModel('Letter');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', WindPlugin::get()->getDefaultStatus())->count();
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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->visibleOn('edit')
                    ->schema([
                        TextEntry::make('sender_info')
                            ->label('Sender Info:')
                            ->columnSpan(['sm' => 2]),

                        TextInput::make('name')
                            ->label(__('zeus-wind::wind.name'))
                            ->required()
                            ->disabled()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label(__('zeus-wind::wind.email'))
                            ->email()
                            ->required()
                            ->disabled()
                            ->maxLength(255),

                        TextInput::make('title')
                            ->label(__('zeus-wind::wind.title'))
                            ->required()
                            ->disabled()
                            ->maxLength(255),

                        TextInput::make('created_at')
                            ->label(__('zeus-wind::wind.sent_at'))
                            ->disabled(),

                        TextEntry::make('message')
                            ->label(__('zeus-wind::wind.message'))
                            ->disabled()
                            ->state(fn (Letter $record) => new HtmlString($record->message))
                            ->columnSpan(['sm' => 2]),
                    ])
                    ->columns(),

                Section::make()
                    ->columnSpanFull()
                    ->visibleOn('edit')
                    ->schema([
                        Select::make('department_id')
                            ->label(__('zeus-wind::wind.department'))
                            ->options(WindPlugin::get()->getModel('Department')::pluck('name', 'id'))
                            ->required()
                            ->visible(fn (): bool => WindPlugin::get()->hasDepartmentResource()),

                        TextInput::make('status')
                            ->label(__('zeus-wind::wind.status'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('reply_title')
                            ->label(__('zeus-wind::wind.reply_title'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(['sm' => 2]),

                        RichEditor::make('reply_message')
                            ->label(__('zeus-wind::wind.reply_message'))
                            ->required()
                            ->maxLength(65535)
                            ->columnSpan(['sm' => 2]),
                    ])
                    ->columns(),

                Section::make()
                    ->columnSpanFull()
                    ->visibleOn('create')
                    ->schema([
                        TextInput::make('name')
                            ->label(__('zeus-wind::wind.to_name'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label(__('zeus-wind::wind.to_email'))
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('title')
                            ->label(__('zeus-wind::wind.title'))
                            ->required()
                            ->maxLength(255),

                        Select::make('department_id')
                            ->label(__('zeus-wind::wind.department'))
                            ->options(WindPlugin::get()->getModel('Department')::pluck('name', 'id'))
                            ->required(fn (): bool => WindPlugin::get()->hasDepartmentResource())
                            ->visible(fn (): bool => WindPlugin::get()->hasDepartmentResource()),

                        RichEditor::make('message')
                            ->label(__('zeus-wind::wind.message'))
                            ->required()
                            ->maxLength(65535)
                            ->columnSpan(['sm' => 2]),
                    ])
                    ->columns(),
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
                            ->label(__('zeus-wind::wind.title')),
                        TextColumn::make('department.name')
                            ->sortable()
                            ->badge()
                            ->searchable()
                            ->toggleable()
                            ->visible(fn (): bool => WindPlugin::get()->hasDepartmentResource())
                            ->label(__('zeus-wind::wind.department')),
                    ]),

                    Stack::make([
                        TextColumn::make('created_at')
                            ->sortable()
                            ->searchable()
                            ->toggleable()
                            ->dateTime()
                            ->label(__('zeus-wind::wind.sent_at')),
                        TextColumn::make('status')
                            ->formatStateUsing(fn (string $state): string => __('zeus-wind::wind.status_' . $state))
                            ->label(__('zeus-wind::wind.status'))
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
            ->toolbarActions([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('status')
                    ->options([
                        'NEW' => __('zeus-wind::wind.new'),
                        'READ' => __('zeus-wind::wind.read'),
                        'REPLIED' => __('zeus-wind::wind.replied'),
                    ])
                    ->label(__('zeus-wind::wind.status')),
                SelectFilter::make('department_id')
                    ->visible(fn (): bool => WindPlugin::get()->hasDepartmentResource())
                    ->options(WindPlugin::get()->getModel('Department')::pluck('name', 'id'))
                    ->label(__('zeus-wind::wind.department')),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make('edit')->label(__('zeus-wind::wind.edit')),
                    DeleteAction::make('delete'),
                    ForceDeleteAction::make(),
                    RestoreAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLetters::route('/'),
            'create' => CreateLetter::route('/create'),
            'edit' => EditLetter::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('zeus-wind::wind.letter');
    }

    public static function getPluralLabel(): string
    {
        return __('zeus-wind::wind.letters');
    }

    public static function getNavigationLabel(): string
    {
        return __('zeus-wind::wind.letters');
    }

    public static function getNavigationGroup(): ?string
    {
        return WindPlugin::get()->getNavigationGroupLabel();
    }
}
