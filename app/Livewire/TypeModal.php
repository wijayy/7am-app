<?php

namespace App\Livewire;

use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;

class TypeModal extends Component
{
    public $title = 'Membership Types';
    public $id;

    #[Validate('required')]
    public $name, $minimum_point;

    protected $listeners = ['openCreateModal' => 'openCreateModal', 'openEditModal' => 'openEditModal'];

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['id', 'name', 'minimum_point']);
        $this->dispatch('modal-show', name: 'create-type');
    }

    public function openEditModal($id)
    {
        $this->resetValidation();
        $type = Type::findOrFail($id);
        $this->fill([
            'id' => $type->id,
            'name' => $type->name,
            'minimum_point' => $type->minimum_point,
        ]);
        $this->dispatch('modal-show', name: 'create-type');
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            Type::updateOrCreate(
                ['id' => $this->id],
                [
                    'name' => $this->name,
                    'minimum_point' => $this->minimum_point,
                ]
            );
            DB::commit();

            $message = $this->id ? 'Membership type updated successfully.' : 'Membership type created successfully.';
            session()->flash('success', $message);
            $this->dispatch('updateType');
            $this->dispatch('modal-close', name: 'create-type');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            session()->flash('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.type-modal')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
