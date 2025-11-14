<?php

namespace App\Livewire;

// use Auth;

use App\Models\Member;
use App\Models\MemberTransaction as ModelsMemberTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MemberTransaction extends Component
{

    public $title = "Add Transaction", $id, $code = '', $name = '', $outlets = [];

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

    public function getMember($id)
    {
        $member = Member::find($id);
        if (!$member) {
            throw new \Exception("Member not found");
        }

        return $member;
    }

    #[On('addTransaction')]
    public function openTransactionModal($id)
    {
        $this->resetValidation();
        $member = $this->getMember($id);

        $this->id = $member->id;
        $this->name = $member->name;
        $this->code = $member->code;
        $this->amount = 0;
        $this->outlet_id = Auth::user()->outlet_id ?? null;

        $this->dispatch('modal-show', name: 'transaction');
    }

    public function inputTransaction()
    {
        // $validated = [];
        try {
            DB::beginTransaction();
            // validasi hanya 3 field
            $validated = $this->validate([
                'amount' => 'required|numeric|min:1',
                'poin' => 'required|integer|min:0',
                'outlet_id' => 'required|exists:outlets,id',
            ]);

            $validated['member_id'] = $this->id;

            ModelsMemberTransaction::create($validated);

            $member = $this->getMember($this->id);

            $member->increment('total_point', $this->poin);
            $member->increment('active_point', $this->poin);

            DB::commit();

            $this->dispatch('updateMember');

            // success message
            $message = "$this->code $this->name successfully get $this->poin points";
            session()->flash('success', $message);

            // reset validations and close modal
            $this->resetValidation();
            $this->dispatch('modal-close', name: 'transaction');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }




    public function render()
    {
        return view('livewire.member-transaction')->layout('components.layouts.app', ['title' => $this->title]);
    }
}