<?php

namespace LaraZeus\Wind\Http\Livewire\Admin;

use LaraZeus\Wind\Models\Category;

class Categories extends WindCrudBase
{
    public $model = Category::class;
    public $title = 'Manage Categories';
    public $titleSingular = 'Category';
    public $breadcrumbTitle = 'Categories';
    public $filters = [
        'search' => '',
        'name' => '',
    ];

    public $logo;

    public $uploads = [
        'logo'
    ];

    public function fields()
    {
        return collect([
            [
                'id' => 'name',
                'type' => 'input.text',
                'label' => 'Category Name',
                'sortable' => true,
                'searchable' => true,
                'rules' => 'required|min:3',
            ],
            [
                'id' => 'slug',
                'type' => 'input.text',
                'label' => 'Category slug',
                'sortable' => true,
                'searchable' => true,
                'rules' => 'required|min:3',
            ],
            [
                'id' => 'ordering',
                'type' => 'input.text',
                'label' => 'Ordering',
                'sortable' => true,
                'rules' => 'required',
            ],
            [
                'id' => 'is_active',
                'type' => 'input.checkbox',
                'label' => 'is_active',
                'sortable' => true,
                'rules' => 'sometimes',
            ],
            [
                'id' => 'logo',
                'type' => 'input.file-upload',
                'label' => 'Category Logo',
                'rules' => 'sometimes',
            ],
        ]);
    }
}