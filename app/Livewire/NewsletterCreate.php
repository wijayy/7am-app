<?php

namespace App\Livewire;

use Livewire\Component;

class NewsletterCreate extends Component
{
    public function render()
    {
        return view('livewire.newsletter-create')->layout('components.layouts.app', ['title'=>""]);
    }
}
