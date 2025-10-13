<?php

namespace App\Livewire;

use Livewire\Component;

class LoyalityShow extends Component
{
    public function render()
    {
        return view('livewire.loyality-show')->layout('components.layouts.app', ['title'=>""]);
    }
}
