<?php

namespace App\Livewire;

use Livewire\Component;

class MemberCreate extends Component
{
    public function render()
    {
        return view('livewire.member-create')->layout('components.layouts.app', ['title'=>""]);
    }
}
