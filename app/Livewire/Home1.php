<?php

namespace App\Livewire;

use Livewire\Component;

class Home1 extends Component
{
    public function render()
    {
        return view('livewire.home1')->layout('components.layouts.app.header', ['title'=>""]);
    }
}
