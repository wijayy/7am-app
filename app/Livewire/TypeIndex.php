<?php

namespace App\Livewire;

use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;

class TypeIndex extends Component
{
    use WithPagination;

    public $title = 'Membership Types';
    public $id;

    #[Validate('required')]
    public $name, $minimum_point;

    protected $paginationTheme = 'tailwind'; // agar pakai Tailwind pagination

    public function updating($name)
    {
        // reset pagination jika ada update input (biar ga stuck di halaman tinggi)
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['id', 'name', 'minimum_point']);
        $this->dispatch('modal-show', name: 'create-member');
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
        $this->dispatch('modal-show', name: 'create-member');
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $type = Type::findOrFail($id);
            $type->delete();
            DB::commit();

            session()->flash('success', 'Membership type deleted successfully.');
            $this->dispatch('modal-close', name: "delete-$id");
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
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
            $this->dispatch('modal-close', name: 'create-member');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    public function render()
    {
        $types = Type::withCount('members')
            ->orderBy('minimum_point')
            ->paginate(2);

        return view('livewire.type-index', [
            'types' => $types,
        ])->layout('components.layouts.app', ['title' => $this->title]);
    }
}
