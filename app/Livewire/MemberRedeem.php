<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Component;
use App\Models\RedeemPoint;
use Livewire\Attributes\On;
use App\Models\MemberRedeem as Redeem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;

class MemberRedeem extends Component
{

    public $title = "Redeem Points", $code = '', $name = '', $outlets = [], $redeems = [], $id;

    #[Validate('required')]
    public $redeem_id = '', $outlet_id = '';

    public function getMember($id)
    {
        $member = Member::find($id);
        if (!$member) {
            throw new \Exception("Member not found");
        }

        return $member;
    }

    #[On('addRedeem')]
    public function openRedeemModal($id)
    {
        $member = $this->getMember($id);

        $this->reedem_id = '';
        $this->outlet_id = '';
        $this->id = $id;

        $this->code = $member->code;
        $this->name = $member->name;

        if (Auth::user()->outlet_id) {
            $this->outlet_id = Auth::user()->outlet_id;
        } else {
            $this->outlets = \App\Models\Outlet::where('is_active', true)->get();
            $this->outlet_id = $this->outlets->first()->id ?? null;
        }

        $this->redeems = RedeemPoint::all();

        $this->dispatch('modal-show', name: 'redeem-point');
    }

    public function mount() {}

    public function redeem()
    {
        try {
            DB::beginTransaction();
            $this->validate();
            // dd('sadfa');

            $member = $this->getMember($this->id);
            $redeem = RedeemPoint::findOrFail($this->redeem_id);
            // dd($member);

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
            $this->dispatch('updateMember');

            // success message
            $message = "$this->code $this->name successfully redeem $redeem->point points";
            session()->flash('success', $message);

            // reset validations and close modal
            $this->resetValidation();
            $this->dispatch('modal-close', name: 'redeem-point');
        } catch (\Throwable $th) {
            // $this->dispatch('modal-close', name: 'redeem-point');
            DB::rollBack();
            throw $th;
            if (config('app.debug') == true) {
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
