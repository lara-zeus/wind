<?php

namespace LaraZeus\Wind\Http\Livewire\User;

use LaraZeus\Wind\Events\LetterSent;
use LaraZeus\Wind\Models\Category;
use LaraZeus\Wind\Models\Letter;
use Livewire\Component;

class ContactsForm extends Component
{
    public $name = 'sdfsdfsdf';
    public $email = 'sdfsdfsdf@sdfsdf.sdfsdf';
    public $category_id = 1;
    public $title = 'sdfsdfsdf';
    public $message = 'sdfsdfsdf';
    public $sent = false;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
        'category_id' => 'required|integer',
        'title' => 'required',
        'message' => 'required',
    ];

    public function mount()
    {
        $this->category_id = config('zeus.wind.defaultCategoryId');
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
        return view('wind::wind-contact-form')
            ->with('categories', Category::where('is_active', 1)->orderBy('ordering')->get());
    }
}