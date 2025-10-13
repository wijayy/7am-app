<?php

namespace App\Livewire\Reservation;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class History extends Component
{

    public $title = "Your Reservation History";

    #[Url(except: '')]
    public $date = '';

    public $history;

    public function mount()
    {
        $this->updatedDate();
    }

    public function updatedDate()
    {
        $this->history = Reservation::where('user_id', Auth::user()->id)->orderByDesc('date')->get();
    }

    public function render()
    {
        return view('livewire.reservation.history')->layout('components.layouts.app.reservation-header', ['title' => $this->title]);
    }
}
