<?php

namespace LaraZeus\Wind\Http\Livewire;

use LaraZeus\Wind\Events\LetterSent;
use LaraZeus\Wind\Models\Department;
use LaraZeus\Wind\Models\Letter;
use Livewire\Component;

class Contacts extends Component
{
    public Department|null $department = null;
    public $name = '';
    public $email = '';
    public $title = '';
    public $message = '';
    public $department_id = '';
    public $sent = false;

    protected function rules()
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
    }

    public function mount(Department $department)
    {
        if (config('zeus-wind.enableDepartments')) {
            if ($department->id === null) {
                $this->department = Department::find(config('zeus-wind.defaultDepartmentId'));
            } else {
                $this->department = $department;
            }
        }
    }

    public function store()
    {
        $valid = $this->validate();
        $valid['status'] = 'NEW';

        $letter = Letter::create($valid);

        $this->sent = true;
        LetterSent::dispatch($letter);
    }

    public function render()
    {
        return view('zeus-wind::contact')
            ->layout(config('zeus-wind.layout'))
            ->with('departments', Department::whereIsActive(1)->orderBy('ordering')->get());
    }
}
