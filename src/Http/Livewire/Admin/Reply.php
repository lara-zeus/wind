<?php

namespace LaraZeus\Wind\Http\Livewire\Admin;

use LaraZeus\Wind\Events\ReplySent;
use LaraZeus\Wind\Models\Letter;
use Livewire\Component;

class Reply extends Component
{
    public Letter $letter;

    protected $rules = [
        'letter.reply_title' => 'required|min:3',
        'letter.reply_message' => 'required|min:3',
    ];

    public function mount(Letter $id)
    {
        $this->letter = $id;
    }

    public function send()
    {
        $valid = $this->validate();
        $valid['status'] = 'REPLIED';

        $this->letter->update($valid);
        ReplySent::dispatch($this->letter);

        return redirect()->route('wind.admin.letters');
    }

    public function render()
    {
        return view('wind::reply-form')
            ->layout('zeus::components.layouts.app');
    }
}