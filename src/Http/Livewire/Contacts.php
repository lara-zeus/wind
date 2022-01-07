<?php

namespace LaraZeus\Wind\Http\Livewire;

use LaraZeus\Wind\Events\LetterSent;
use LaraZeus\Wind\Models\Category;
use LaraZeus\Wind\Models\Letter;
use Livewire\Component;

class Contacts extends Component
{
    public ?string $category = null;
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

    public function mount(Category $category)
    {
        if ($category->id === null) {
            $this->category_id = config('zeus-wind.defaultCategoryId');
        } else {
            $this->category_id = $category->id;
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
            ->with('categories', Category::whereIsActive(1)->orderBy('ordering')->get());
    }
}