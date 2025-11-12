<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class Invoice extends Component
{

    public $title, $transaction;

    public function mount($slug)
    {
        try {
            $this->transaction = Transaction::where('slug', $slug)->firstOrFail();
            $this->title = "Invoice {$this->transaction->transaction_number}";
        } catch (\Throwable $th) {
            return redirect(route('history'))->with('error', "Invoice tidak ditemukan");
        }
    }

    public function render()
    {
        return view('livewire.invoice')->layout('components.layouts.invoice', ['title' => $this->title]);
    }
}
