<?php

namespace App\Livewire;

use App\Models\Outlet;
use Livewire\Attributes\On;
use Livewire\Component;

class OutletIndex extends Component
{

    public $title = "Outlet", $outlets;

    #[On('updateOutlet')]
    public function getOutlet()
    {
        $this->outlets = Outlet::where('is_active', true)->get();
    }

    public function openCreateModal()
    {
        $this->dispatch('openCreateModal');
    }

    public function openEditModal($id)
    {
        $this->dispatch('openEditModal', id: $id);
    }


    public function mount()
    {
        $this->outlets = Outlet::all();
    }

    public function render()
    {
        return view('livewire.outlet-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
