<?php

namespace App\Livewire;

use Livewire\Component;

class SetCategories extends Component
{

    public $title = "";

    public function render()
    {
        return view('livewire.set-categories')->layout('components.layouts.app', ['title'=>$this->title]);
    }
}
