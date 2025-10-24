<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RedeemPoint;
use Livewire\Attributes\On;
use App\Models\MemberRedeem as Redeem;
use Illuminate\Support\Facades\DB;

class MemberRedeem extends Component
{

    public $title = "Redeem Points";

    #[On('addRedeem')]
    public function redeem()
    {
        try {
            DB::beginTransaction();
            $this->validateOnly($this->redeem_id);

            $member = $this->getMember($this->id);
            $redeem = RedeemPoint::findOrFail($this->redeem_id);

            if ($member->active_point < $redeem->point) {
                throw new \Exception("Sorry, you don’t have enough points to redeem this reward.");
            }

            Redeem::create([
                'member_id' => $member->id,
                'redeem_point_id' => $redeem->id,
                'outlet_id' => $this->outlet_id,
            ]);

            $member->decrement('active_point', $redeem->point);

            DB::commit();
            // refresh list
            $this->getMembers();

            // success message
            $message = "$this->code $this->name successfully redeem $redeem->point points";
            session()->flash('success', $message);

            // reset validations and close modal
            $this->resetValidation();
            $this->dispatch('modal-close', name: 'redeem-point');
        } catch (\Throwable $th) {
            $this->dispatch('modal-close', name: 'redeem-point');
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
        return view('livewire.member-redeem')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
