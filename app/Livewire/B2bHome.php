<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class B2bHome extends Component
{
    public $products;
    public function mount()
    {
        $this->products = Product::latest()->take(12)->get();
    }

    public function render()
    {
        return view('livewire.b2b-home')->layout('components.layouts.app.header', ['title' => "Home"]);
    }
}
