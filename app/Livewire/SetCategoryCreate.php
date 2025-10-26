<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\SetCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SetCategoryCreate extends Component
{

    public $title = "", $categories, $selectedCategories, $id;

    #[Validate('required')]
    public $name = '';

    #[On('createModal')]
    public function openCreateModal()
    {
        $this->resetValidation();

        $this->name = '';

        $this->selectedCategories = [];

        $this->dispatch('modal-show', name: 'set-category-create');
    }

    #[On('editModal')]
    public function openEditModal($id)
    {
        $setCategory = SetCategory::where('id', $id)->first();

        if (!$setCategory) {
            return;
        }

        $this->resetValidation();

        $this->id = $setCategory->id;
        $this->name = $setCategory->name;
        $this->selectedCategories = $setCategory->categories()->pluck('id')->toArray();

        $this->dispatch('modal-show', name: 'set-category-create');
    }

    public function togglecategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            // kalau sudah ada → hapus
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        } else {
            // kalau belum ada → tambahkan
            $this->selectedCategories[] = $categoryId;
        }
    }

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            // UpdateOrCreate SetCategory
            $setCategory = SetCategory::updateOrCreate(
                ['id' => $this->id], // condition
                ['name' => $this->name] // values to update/create
            );

            // Sync categories
            $setCategory->categories()->sync($this->selectedCategories);
            DB::commit();

            session()->flash('success', 'Set category saved successfully');
            $this->dispatch('updateSetCategory');
            $this->dispatch('modal-close', name: 'set-category-create');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug')) {
                throw $th;
            }
            session()->flash('error', 'Error saving set category');
        }
    }

    public function render()
    {
        return view('livewire.set-category-create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
