<?php

namespace App\Livewire;

use Livewire\Component;

class LoyalityCreate extends Component
{
    public function render()
    {
        return view('livewire.loyality-create')->layout('components.layouts.app', ['title'=>""]);
    }
}
