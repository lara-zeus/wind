<?php

namespace LaraZeus\Wind\Http\Livewire;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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

    public ?int $department_id;

    public bool $sent = false;

    public string $status = 'NEW';

    public function mount(string $departmentSlug = null): void
    {
        if (WindPlugin::get()->hasDepartmentResource()) {
            if ($departmentSlug !== null) {
                $this->department = WindPlugin::get()->getDepartmentModel()::where('slug', $departmentSlug)->first();
            } elseif (WindPlugin::get()->getDefaultDepartmentId() !== null) {
                $this->department = WindPlugin::get()->getDepartmentModel()::find(WindPlugin::get()->getDefaultDepartmentId());
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
        $letter = WindPlugin::get()->getLetterModel()::create($this->form->getState());
        $this->sent = true;
        LetterSent::dispatch($letter);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    ViewField::make('department_id')
                        ->view(app('windTheme').'.departments')
                        ->columnSpan([
                            'default' => 1,
                            'md' => 2,
                        ])
                        ->label('')
                        ->visible(fn(): bool => WindPlugin::get()->hasDepartmentResource()),

                    Section::make('')
                        ->schema([
                            TextInput::make('name')
                                ->columnSpan(1)
                                ->required()
                                ->minLength(6)
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
