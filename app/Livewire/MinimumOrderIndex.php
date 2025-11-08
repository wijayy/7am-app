<?php

namespace App\Livewire;

use App\Models\MinimumOrder;
use App\Models\Village;
use Livewire\Attributes\On;
use Livewire\Component;

class MinimumOrderIndex extends Component
{

    public $title = "Minimum Orders", $minimumOrders, $villages;

    #[On('update-minimum-order')]
    public function mount()
    {
        $this->minimumOrders = MinimumOrder::all();
        $this->villages = Village::all();
    }


    public function render()
    {
        return view('livewire.minimum-order-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
