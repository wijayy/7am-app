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
        $this->resetValidation();
        $member = $this->getMember($id);

        $this->id = $member->id;
        $this->name = $member->name;
        $this->code = $member->code;
        $this->amount = 0;
        $this->outlet_id = Auth::user()->outlet_id ?? null;

        $this->dispatch('modal-show', name: 'transaction');
    }

    public function updatedAmount()
    {
        if (is_numeric($this->amount)) {
            $this->poin = floor($this->amount / 10000);
        }
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

            MemberTransaction::create($validated);

            $member = $this->getMember($this->id);

            $member->increment('total_point', $this->poin);
            $member->increment('active_point', $this->poin);

            DB::commit();

            $this->getMembers();

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
        return view('livewire.member-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
