<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\Member;
use App\Models\MemberRedeem;
use App\Models\MemberTransaction;
use App\Models\Outlet;
use App\Models\RedeemPoint;
use App\Models\Setting;
use App\Models\Type;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MemberIndex extends Component
{

    public $title = "Our Beloved Members";

    public $members, $types;

    #[Url(except: '')]
    public $search = '';

    #[Url(as: 'type', except: '')]
    public $ty = '';

    #[Validate('required')]
    public $poin = 0, $amount = 0;

    public function mount()
    {
        $this->types = Type::all();

        $this->input_point = Setting::where('key', 'input_point')->value('value') == 'true' ? true : false;

        $this->getMembers();

        // dd($this->id || $this->input_point);
    }

    public function updatedSearch()
    {
        $this->getMembers();
    }

    public function updatedTy()
    {
        $this->getMembers();
    }

    public function openCreateModal()
    {
        // clear validation and inputs
        $this->dispatch('addMember');
    }

    public function openEditModal($id)
    {
        $this->dispatch('editMember', id: $id);
    }



    #[On('updateMember')]
    public function getMembers()
    {
        $this->members = Member::filters(['search' => $this->search, 'type' => $this->ty])->get();
    }

    public function getMember($id)
    {
        $member = Member::find($id);
        if (!$member) {
            throw new \Exception("Member not found");
        }

        return $member;
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $member = $this->getMember($id);

            $member->delete();

            DB::commit();

            // refresh list
            $this->getMembers();

            session()->flash('success', 'Member deleted successfully.');

            // optional: notify frontend to close any delete confirmation
            $this->dispatch('modal-close', name: "delete-$id");
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }

    public function openRedeemModal($id)
    {
        $this->dispatch('addRedeem', id: $id);
    }

    public function openTransactionModal($id)
    {
        $this->dispatch('addTransaction', id: $id);
    }

    public function updatedAmount()
    {
        if (is_numeric($this->amount)) {
            $this->poin = floor($this->amount / 10000);
        }
    }


    public function render()
    {
        return view('livewire.member-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}