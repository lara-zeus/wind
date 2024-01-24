<?php

namespace LaraZeus\Wind\Livewire;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\IconSize;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use LaraZeus\Wind\Events\LetterSent;
use LaraZeus\Wind\Models\Department;
use LaraZeus\Wind\WindPlugin;
use Livewire\Component;

/**
 * @property mixed $form
 */
class ContactsForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public ?Department $department = null;

    public string $name = '';

    public string $email = '';

    public string $title = '';

    public string $message = '';
    public string $type = '';

    public ?int $department_id;

    public bool $sent = false;

    public string $status = 'NEW';

    public function mount(?string $departmentSlug = null): void
    {
        if (WindPlugin::get()->hasDepartmentResource()) {
            if ($departmentSlug !== null) {
                $this->department = WindPlugin::get()->getModel('Department')::where('slug', $departmentSlug)->first();
            } elseif (WindPlugin::get()->getDefaultDepartmentId() !== null) {
                $this->department = WindPlugin::get()->getModel('Department')::find(WindPlugin::get()->getDefaultDepartmentId());
            }
        }

        $this->status = WindPlugin::get()->getDefaultStatus();

        $this->form->fill(
            [
                'department_id' => $this->department->id ?? null,
                'status' => WindPlugin::get()->getDefaultStatus(),
            ]
        );
    }

    public function store(): void
    {
        $letter = WindPlugin::get()->getModel('Letter')::create($this->form->getState());
        $this->sent = true;
        LetterSent::dispatch($letter);
    }

    protected function getFormSchema(): array
    {
        $options = $icons = $descriptions = [];
        if (\LaraZeus\Wind\WindPlugin::get()->hasDepartmentResource()) {
            $departments = \LaraZeus\Wind\WindPlugin::get()->getModel('Department')::departments()->get();

            $options = $departments->pluck('name', 'id');
            $icons = $departments->mapWithKeys(function ($item) {
                return [
                    $item->id => $item->image() ?? 'heroicon-s-envelope'
                ];
            });
            $descriptions = $departments->pluck('desc', 'id');
        }
        return [
            Grid::make()
                ->schema([
                    RadioDeck::make('department_id')
                        ->visible(fn(): bool => WindPlugin::get()->hasDepartmentResource())
                        ->label(__('Select Department'))
                        ->required()
                        ->options($options)
                        ->descriptions($descriptions)
                        ->icons($icons)
                        ->iconSize('lg') // Small | Medium | Large | (string - sm | md | lg)
                        ->iconPosition(IconPosition::Before) // Before | After | (string - before | after)
                        ->iconSizes([ // Customize the values for each icon size
                            'sm' => 'h-12 w-12',
                            'md' => 'h-14 w-14',
                            'lg' => 'h-20 md:h-32',
                        ])
                        ->color('secondary') // supports all color custom or not
                        ->columns()
                        ->alignment(Alignment::Center) // Start | Center | End | (string - start | center | end)
                        ->gap('gap-2') // Gap between Icon and Description (Any TailwindCSS gap-* utility)
                        ->padding('duration-200 transition ease-in-out shadow-md px-2 py-4') // Padding around the deck (Any TailwindCSS padding utility)
                        ->direction('column') // Column | Row (Allows to place the Icon on top)
                        ->extraOptionsAttributes([ // Extra Attributes to add to the option HTML element
                            'class' => '*:text-primary-500 text-xl leading-none w-full flex flex-col items-center justify-center py-2'
                        ])
                        ->extraDescriptionsAttributes([ // Extra Attributes to add to the description HTML element
                            'class' => 'text-sm font-light !text-gray-600 my-1 text-center'
                        ])
                        ->columnSpanFull(),

                    Section::make()
                        ->schema([
                            TextInput::make('name')
                                ->columnSpan(1)
                                ->required()
                                ->minLength(4)
                                ->label(__('name')),

                            TextInput::make('email')
                                ->columnSpan(1)
                                ->required()
                                ->email()
                                ->label(__('email')),

                            TextInput::make('title')
                                ->columnSpan(2)
                                ->required()
                                ->label(__('title')),

                            Textarea::make('message')
                                ->columnSpan(2)
                                ->rows(10)
                                ->required()
                                ->label(__('message')),
                        ])
                        ->columns([
                            'default' => 1,
                            'md' => 2,
                        ]),
                ]),
        ];
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        seo()
            ->site(config('zeus.site_title', 'Laravel'))
            ->title(__('Contact Us').' - '.config('zeus.site_title'))
            ->description(__('Contact Us').' - '.config('zeus.site_description').' '.config('zeus.site_title'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="'.asset('favicon/favicon.ico').'">')
            ->rawTag('<meta name="theme-color" content="'.config('zeus.site_color').'" />')
            ->withUrl()
            ->twitter();

        return view(app('windTheme').'.contact-form')
            ->layout(config('zeus.layout'));
    }
}
