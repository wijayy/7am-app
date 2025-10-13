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
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MemberIndex extends Component
{

    public $title = "All Members";

    public $members, $types, $id = 1, $input_point, $redeems, $outlets, $cards;

    #[Url(except: '')]
    public $search = '';

    #[Url(as: 'type', except: '')]
    public $ty = '';

    #[Validate('required|string')]
    public $name = '', $code;

    #[Validate('required|doesnt_start_with:0')]
    public $phone = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $type_id = 1, $birthday = '', $redeem_id, $outlet_id, $card_id;

    #[Validate('required_if:input_point,true')]
    public $point = 0;

    #[Validate('required')]
    public $poin = 0, $amount = 0;

    public function mount()
    {
        $this->types = Type::all();

        $this->input_point = Setting::where('key', 'input_point')->value('value') == 'true' ? true : false;

        $this->getMembers();

        // dd($this->id || $this->input_point);
    }

    public function openCreateModal()
    {
        // clear validation and inputs
        $this->resetValidation();
        $this->id = null;
        $this->name = '';
        $this->code = null;
        $this->phone = null;
        $this->email = '';
        $this->birthday = '';
        $this->type_id = 1;
        $this->type_id = 1;
        $this->point = 0;

        $this->dispatch('modal-show', name: 'create-member');
    }

    public function openEditModal($id)
    {
        $this->resetValidation();
        $member = Member::find($id);
        if (!$member) {
            session()->flash('error', 'Member not found.');
            return;
        }

        $this->id = $member->id;
        $this->name = $member->name;
        $this->code = $member->code;
        $this->phone = $member->phone;
        $this->email = $member->email;
        $this->type_id = $member->type_id;
        $this->card_id = $member->card_id;
        $this->point = $member->total_point;
        $this->birthday = optional($member->birthday)->format('Y-m-d') ?? '';

        $this->dispatch('modal-show', name: 'create-member');
    }

    public function updatedSearch()
    {
        $this->getMembers();
    }

    public function updatedTy()
    {
        $this->getMembers();
    }

    public function getMembers()
    {
        $this->members = Member::filters(['search' => $this->search, 'type' => $this->ty])->get();
        $this->redeems = RedeemPoint::orderBy('point')->get();
        $this->outlets = Outlet::all();
        $this->cards = Card::all();
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

    public function save()
    {
        try {
            DB::beginTransaction();
            $validated = $this->validate();

            unset($validated['point']);
            if (!$this->id) {
                $validated['total_point'] = $this->point;
                $validated['active_point'] = $this->point;
            }

            Member::updateOrCreate(['id' => $this->id], $validated);

            DB::commit();

            // refresh list
            $this->getMembers();

            // success message
            $message = $this->id ? 'Member updated successfully.' : 'Member created successfully.';
            session()->flash('success', $message);

            // reset validations and close modal
            $this->resetValidation();
            $this->dispatch('modal-close', name: 'create-member');
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
        $this->resetValidation();
        $member = $this->getMember($id);

        $this->id = $member->id;
        $this->name = $member->name;
        $this->code = $member->code;
        $this->redeem_id = null;
        $this->outlet_id = Auth::user()->outlet_id ?? null;


        $this->dispatch('modal-show', name: 'redeem-point');
    }

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

            MemberRedeem::create([
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
