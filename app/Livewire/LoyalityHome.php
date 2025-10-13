<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\Member;
use App\Models\RedeemPoint;
use Livewire\Component;

class LoyalityHome extends Component
{

    public $title = "Membership Program", $cards, $redeems, $name, $code;

    public function mount()
    {
        $this->cards = Card::all();
        $this->redeems = RedeemPoint::orderBy('point')->get();
    }

    public function track()
    {
        $validated = $this->validate(['name' => 'required', 'code' => 'required']);

        try {
            $member = Member::where('name', $this->name)->where('code', $this->code)->firstOrFail();

            return redirect()->route('member.show')->with('slug', $member->slug);

        } catch (\Throwable $th) {
            session()->flash('error', "Member not found.");
        }
    }

    public function render()
    {
        return view('livewire.loyality-home')->layout('components.layouts.app.reservation-header', ['title' => $this->title]);
    }
}
