<?php

namespace LaraZeus\Wind\Http\Livewire;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use LaraZeus\Wind\Events\LetterSent;
use LaraZeus\Wind\Models\Department;
use LaraZeus\Wind\Models\Letter;
use Livewire\Component;

class ContactsForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Department|null $department = null;
    public $name = '';
    public $email = '';
    public $title = '';
    public $message = '';
    public $department_id;
    public $sent = false;
    public $status = 'NEW';

    public function mount($departmentSlug)
    {
        if (config('zeus-wind.enableDepartments')) {
            if ($departmentSlug !== null) {
                $this->department = Department::whereSlug($departmentSlug)->first();
            } else {
                $this->department = Department::find(config('zeus-wind.defaultDepartmentId'));
            }
        }

        $this->form->fill(
            [
                'department_id' => $this->department->id ?? 0,
                'status' => config('zeus-wind.default_status'),
            ]
        );
    }

    public function store()
    {
        $letter = Letter::create($this->form->getState());
        $this->sent = true;
        LetterSent::dispatch($letter);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make()->schema([
                ViewField::make('department_id')
                    ->view('zeus-wind::departments')
                    ->columnSpan([
                        'default' => 1,
                        'sm' => 1,
                        'md' => 2,
                    ])
                    ->label(__('Departments'))
                    ->visible(fn (): bool => config('zeus-wind.enableDepartments')),

                TextInput::make('name')->required()->minLength('6')->label(__('name')),
                TextInput::make('email')->required()->email()->label(__('email')),
            ])->columns([
                'default' => 1,
                'sm' => 1,
                'md' => 2,
            ]),

            Grid::make()->schema([
                TextInput::make('title')->required()->label(__('title')),
                Textarea::make('message')->required()->label(__('message')),
            ])->columns(1),
        ];
    }

    public function render()
    {
        return view('zeus-wind::contact-form')
            ->with('departments', Department::whereIsActive(1)->orderBy('ordering')->get());
    }
}
