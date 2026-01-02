<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TransactionPay extends Component
{

    public $title = "Pay Transaction", $id, $transaction;

    #[Validate('required|numeric|min:1')]
    public $amount = '';

    #[Validate('required|string')]
    public $payment_type = '';

    #[On("pay-modal")]
    public function openPayModal($id)
    {
        // dd($id);
        $this->id = $id;
        $this->transaction = Transaction::find($id);

        if ($this->transaction->payment) {
            return;
        }
        // dd($this->transaction);
        $this->dispatch('modal-show', name: 'pay-transaction');
    }


    public function save()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            if ($this->amount != $this->transaction->total) {
                Session::flash('error', 'Amount must be equal to transaction total amount');
                return;
            }

            $this->transaction->update(['status' => 'paid']);
            $this->transaction->payment()->create([
                'amount' => $this->amount,
                'payment_type' => $this->payment_type,
                'payment_status' => 'paid'
            ]);
            DB::commit();
            session()->flash('success', 'Transaction paid successfully');
            $this->dispatch('modal-close', name: 'pay-transaction');

            $this->dispatch('update-transaction');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            session()->flash('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.transaction-pay')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
