<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminIndex extends Component
{

    public $title = "Our Admins", $admins;

    public function mount()
    {
        $this->title = "Our Admins";
        $this->admins = User::whereNot('role', 'customer')->get();
    }

    #[On('updateAdmins')]
    public function getAdmins()
    {
        $this->admins = User::whereNot('role', 'customer')->get();
    }

    public function render()
    {
        return view('livewire.admin-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}