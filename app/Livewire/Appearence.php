<?php

namespace App\Livewire;

use Livewire\Component;

class Appearence extends Component
{
    public function render()
    {
        return view('livewire.appearence')->layout('components.layouts.app.header', ['title'=>"Appearence"]);
    }
}
