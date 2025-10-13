<?php

namespace App\Livewire;

use App\Models\Reservation;
use Livewire\Attributes\Url;
use Livewire\Component;

class ReservationIndex extends Component
{

    public $title = 'All Reservation', $reservations;

    #[Url(except: '')]
    public $date;


    public function mount()
    {
        $this->date = $this->date ?? date('Y-m-d');
        $this->updatedDate();
    }

    public function updatedDate()
    {
        $this->reservations = Reservation::filters(['date' => $this->date])->get();
    }

    public function render()
    {
        return view('livewire.reservation-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
