<?php

namespace App\Livewire;

use Livewire\Component;

class WholesaleIndex extends Component
{

    public $title = "Wholesale";

    public function render()
    {
        return view('livewire.wholesale-index')->layout('components.layouts.app.header', ['title'=>$this->title]);
    }
}
