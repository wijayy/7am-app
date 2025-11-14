<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CategoryCreate extends Component
{
    public $title, $category;

    #[Validate('required|string')]
    public $name = '';

    public function mount($slug = null)
    {
        if ($slug) {
            $category = Category::where('slug', $slug)->firstOrFail();
            $this->category = $category->id;
            $this->name = $category->name;
            $this->title = "Edit Category $this->name";
        } else {
            $this->title = "Add New Category";
        }
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            $this->validate();

            Category::updateOrCreate(['id' => $this->category], ['name' => $this->name]);
            DB::commit();

            return redirect()->route('category.index')->with('success', $this->category ? "$this->name has been successfully modified" :'New Category Successfully Added');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }


    public function render()
    {
        return view('livewire.category-create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
