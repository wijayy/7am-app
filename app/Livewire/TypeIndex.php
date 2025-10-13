<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\Type;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;

class TypeIndex extends Component
{

    public $title = 'Membership Types';

    public $types, $id;

    #[Validate('required')]
    public $name, $minimum_point;

    public function mount()
    {
        $this->types = Type::all();
    }

    public function openCreateModal()
    {
        // clear previous validation errors and inputs, then show modal
        $this->resetValidation();
        $this->id = null;
        $this->name = null;
        $this->minimum_point = null;

        $this->dispatch('modal-show', name: 'create-member');
        // dd(true);
    }

    public function openEditModal($id)
    {
        // clear previous validation errors before loading data
        $this->resetValidation();
        $member = Type::find($id);
        $this->id = $member->id;
        $this->name = $member->name;
        $this->minimum_point = $member->minimum_point;

        $this->dispatch('modal-show', name: 'create-member');
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $member = Type::find($id);

            $member->delete();

            DB::commit();

            $this->types = Type::all();

            // success message for delete
            session()->flash('success', 'Membership type deleted successfully.');

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
        // $validated = $this->validate();
        try {
            DB::beginTransaction();
            Type::updateOrCreate(['id' => $this->id], [
                'name' => $this->name,
                'minimum_point' => $this->minimum_point,
            ]);

            DB::commit();

            // refresh list
            $this->types = Type::all();

            // success message: different for create vs update
            $message = $this->id ? 'Membership type updated successfully.' : 'Membership type created successfully.';
            session()->flash('success', $message);

            // close modal on frontend
            // $this->resetValidation();
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
        return view('livewire.type-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
