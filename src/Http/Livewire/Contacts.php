<?php

namespace LaraZeus\Wind\Http\Livewire;

use LaraZeus\Wind\Events\LetterSent;
use LaraZeus\Wind\Models\Category;
use LaraZeus\Wind\Models\Letter;
use Livewire\Component;

class Contacts extends Component
{
    public Category|null $category = null;
    public $name = '';
    public $email = '';
    public $title = '';
    public $message = '';
    public $category_id = '';
    public $sent = false;

    protected function rules()
    {
        $rules = [
            'name' => 'required|min:6',
            'email' => 'required|email',
            'title' => 'required',
            'message' => 'required',
        ];

        if (config('zeus-wind.enableCategories')) {
            $rules['category_id'] = 'required|integer';
        }

        return $rules;
    }

    public function mount(Category $category)
    {
        if (config('zeus-wind.enableCategories')) {
            if ($category->id === null) {
                $this->category = Category::find(config('zeus-wind.defaultCategoryId'));
            } else {
                $this->category = $category;
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
            ->with('categories', Category::whereIsActive(1)->orderBy('ordering')->get());
    }
}
