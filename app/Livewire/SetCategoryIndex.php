<?php

namespace App\Livewire;

use App\Models\SetCategory;
use App\Models\Setting;
use Livewire\Attributes\On;
use Livewire\Component;

class SetCategoryIndex extends Component
{

    public $title = "Set Category";

    public $setCategories;

    public function openCreateModal()
    {
        $this->dispatch('createModal');
    }

    public function openEditModal($id)
    {
        $this->dispatch('editModal', id: $id);
    }

    public function delete($id)
    {
        if (Setting::where('key', 'default_set_category')->value('value') == $id) {
            session()->flash('error', 'Default Set Category cannot be deleted');
            return;
        }

        $setCategory = SetCategory::find($id);

        if ($setCategory) {
            $setCategory->delete();
            session()->flash('success', 'Set category deleted successfully');
            $this->dispatch('modal-close', name: 'delete-'.$id);
            $this->redirect(route('set-category.index'));
        } else {
            session()->flash('error', 'Set category not found');
        }
    }

    #[On('updateSetCategory')]
    public function updateSetCategory()
    {
        $this->setCategories = SetCategory::all();
    }

    public function mount()
    {
        $this->setCategories = SetCategory::all();
    }

    public function render()
    {
        return view('livewire.set-category-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
