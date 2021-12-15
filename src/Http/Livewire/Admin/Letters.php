<?php

namespace LaraZeus\Wind\Http\Livewire\Admin;

use LaraZeus\Wind\Models\Letter;

class Letters extends WindCrudBase
{
    public $model = Letter::class;
    public $title = 'Manage Letters';
    public $titleSingular = 'Letter';
    public $breadcrumbTitle = 'Letters';

    public $oprations = [
        'search' => true,
        'filters' => true,
        'bulkActions' => true,
        'create' => false,
        'edit' => false,
        'delete' => true,
        'show' => false,
    ];

    public $filters = [
        'search' => '',
        'name' => '',
        'values' => '',
    ];

    public function buttons()
    {
        return [
            'formEntries' => [
                'title' => 'Reply',
                'link' => 'wind.admin.letter.reply:id',
                'icon' => 'heroicon-o-clipboard-list',
            ],
        ];
    }

    public function fields()
    {
        return collect([
            [
                'id' => 'name',
                'type' => 'input.text',
                'label' => 'Name',
                'sortable' => true,
                'searchable' => true,
                'rules' => 'required|min:3',
            ],
            [
                'id' => 'email',
                'type' => 'input.text',
                'label' => 'Email',
                'sortable' => true,
                'searchable' => true,
                'rules' => 'required|email',
            ],
            [
                'id' => 'title',
                'type' => 'input.text',
                'label' => 'Title',
                'sortable' => true,
                'searchable' => true,
                'rules' => 'required|min:3',
            ],
            [
                'id' => 'message',
                'type' => 'input.text',
                'label' => 'Message',
                'sortable' => false,
                'searchable' => true,
                'formOnly' => true,
                'rules' => 'required|min:3',
            ],
            [
                'id' => 'status',
                'type' => 'input.text',
                'label' => 'Status',
                'sortable' => true,
                'searchable' => true,
                'formOnly' => false,
                'rules' => 'required|min:3',
            ],
        ]);
    }
}