<?php

namespace App\Livewire;

use Livewire\Component;

class NewsletterIndex extends Component
{
    public function render()
    {
        return view('livewire.newsletter-index')->layout('components.layouts.app', ['title' => "Newsletter"]);
    }
}
