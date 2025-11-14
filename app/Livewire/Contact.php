<?php

namespace App\Livewire;

use Livewire\Component;

class Contact extends Component
{
    public function render()
    {
        return view('livewire.contact')->layout('components.layouts.app.header', ['title' => "Our Contact"]);
    }
}
