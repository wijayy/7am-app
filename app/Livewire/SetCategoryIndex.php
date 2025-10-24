<?php

namespace App\Livewire;

use Livewire\Component;

class SetCategoryIndex extends Component
{

    public $title = "Set Category";

    public $setCategories;



    public function render()
    {
        return view('livewire.set-category-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
