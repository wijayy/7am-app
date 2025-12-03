<?php

namespace App\Livewire;

use App\Models\Outlet;
use App\Models\Product;
use Livewire\Component;

class Home extends Component
{

    public $outlets;



    public function mount()
    {


        $this->outlets = Outlet::get();
    }

    public function render()
    {
        return view('livewire.home')->layout('components.layouts.app.reservation-header', ['title' => 'Home']);
    }
}
