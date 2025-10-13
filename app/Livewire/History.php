<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class History extends Component
{
    public $transactions;

    public function mount() {
        $this->transactions = Transaction::where('user_id', Auth::user()->id)->get();
    }

    public function render()
    {
        return view('livewire.history')->layout('components.layouts.app.header', ['title'=>'History Transaction']);
    }
}
