<?php

namespace App\Livewire;

use Livewire\Component;

class OutletIndex extends Component
{
    public function render()
    {
        return view('livewire.outlet-index')->layout('components.layouts.app', ['title'=>""]);
    }
}
