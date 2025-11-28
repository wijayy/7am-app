<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class MemberCreate extends Component
{
    public $title, $cards, $types, $id, $input_point;

    #[Validate('required|string')]
    public $name = '', $code;

    #[Validate('required|doesnt_start_with:0', message: ['doesnt_start_with' => 'Phone number must start with a country code'])]
    public $phone = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $type_id = 1, $birthday = '', $card_id;

    #[Validate('required_if:input_point,true')]
    public $point = 0;


    public function mount()
    {
        $this->types = \App\Models\Type::all();
        $this->cards = \App\Models\Card::all();
        $this->input_point = \App\Models\Setting::where('key', 'input_point')->value('value') == 'true' ? true : false;
    }

    #[On('addMember')]
    public function openCreateModal()
    {
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
        $this->title = "Add New Member";

        $this->dispatch('modal-show', name: 'create-member');
    }

    #[On('editMember')]
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

        $this->title = "Edit Member $this->name";

        $this->dispatch('modal-show', name: 'create-member');
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
            // $this->getMembers();

            // success message
            $message = $this->id ? 'Member updated successfully.' : 'Member created successfully.';
            session()->flash('success', $message);

            // reset validations and close modal
            $this->resetValidation();
            $this->dispatch('updateMember');
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

    public function render()
    {
        return view('livewire.member-create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
