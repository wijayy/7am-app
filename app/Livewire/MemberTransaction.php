<?php

namespace App\Livewire;

// use Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MemberTransaction extends Component
{

    public $title = "Add Transaction", $id, $outlets;

    #[Validate('required')]
    public $amount = 0, $poin = 0, $outlet_id;

    public function updatedAmount($value)
    {
        if (is_numeric($this->amount)) {
            $this->poin = floor($this->amount / 10000);
        }
    }

    public function mount()
    {
        if (Auth::user()->outlet_id) {
            $this->outlet_id = Auth::user()->outlet_id;
        } else {
            $this->outlets = \App\Models\Outlet::all();
            $this->outlet_id = $this->outlets->first()->id ?? null;
        }
    }



    public function render()
    {
        return view('livewire.member-transaction')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
