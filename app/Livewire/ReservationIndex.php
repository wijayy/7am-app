<?php

namespace App\Livewire;

use App\Models\Reservation;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ReservationIndex extends Component
{
    use WithPagination;

    public $title = 'All Reservation';

    #[Url(except: '')]
    public $date;

    // Agar pagination tetap di halaman 1 saat filter berubah
    public function updatedDate()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->date = $this->date ?? date('Y-m-d');
    }

    public function render()
    {
        $reservations = Reservation::filters(['date' => $this->date])
            ->with(['outlet', 'section'])
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('livewire.reservation-index', [
            'reservations' => $reservations,
        ])->layout('components.layouts.app', [
            'title' => $this->title,
        ]);
    }
}
