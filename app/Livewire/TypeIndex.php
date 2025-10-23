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

    protected $paginationTheme = 'tailwind'; // agar pakai Tailwind pagination

    public function updating($name)
    {
        // reset pagination jika ada update input (biar ga stuck di halaman tinggi)
        $this->resetPage();
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

    public function render()
    {
        $types = Type::withCount('members')
            ->orderBy('minimum_point')
            ->paginate(10);

        return view('livewire.type-index', [
            'types' => $types,
        ])->layout('components.layouts.app', ['title' => $this->title]);
    }
}
