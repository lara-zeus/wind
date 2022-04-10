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

class Contacts extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Department|null $department = null;
    public $name = '';
    public $email = '';
    public $title = '';
    public $message = '';
    public $department_id = '';
    public $sent = false;
    public $status = 'NEW';

    /*protected function rules()
    {
        $rules = [
            'name' => 'required|min:6',
            'email' => 'required|email',
            'title' => 'required',
            'message' => 'required',
        ];

        if (config('zeus-wind.enableDepartments')) {
            $rules['department_id'] = 'required|integer';
        }

        return $rules;
    }*/

    public function mount(Department $department)
    {
        if (config('zeus-wind.enableDepartments')) {
            if ($department->id === null) {
                $this->department = Department::find(config('zeus-wind.defaultDepartmentId'));
            } else {
                $this->department = $department;
            }
        }

        $this->form->fill();
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
                    ->columnSpan(2)
                    ->label(__('Departments'))
                    ->hidden(fn (): bool => ! config('zeus-wind.enableDepartments')),

                TextInput::make('name')->required()->minLength('6'),
                TextInput::make('email')->required()->email(),
            ])->columns(2),

            Grid::make()->schema([
                TextInput::make('title')->required(),
                Textarea::make('message')->required(),
            ])->columns(1),

            Forms\Components\Hidden::make('status')->default('NEW'),
        ];
    }

    public function render()
    {
        return view('zeus-wind::contact')
            ->with('departments', Department::whereIsActive(1)->orderBy('ordering')->get())
            ->layout(config('zeus-wind.layout'));
    }
}
