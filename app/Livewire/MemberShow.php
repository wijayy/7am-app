<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\MemberTransaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MemberShow extends Component
{
    public $title = "", $open = 'transaction';

    public Member $member;

    public function mount($slug)
    {
        try {
            $this->member = Member::where('slug', $slug)->firstOrFail();

            $this->title = "Detail of {$this->member->code} {$this->member->name}";
        } catch (\Throwable $th) {
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.member-show')->layout('components.layouts.app.reservation-header', ['title' => $this->title]);
    }
}
