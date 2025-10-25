<?php

namespace App\Livewire;

use App\Models\Category;
use App\Services\JurnalApi;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CategoryIndex extends Component
{

    public $categories;
    protected $jurnalApi;

    public function mount()
    {
        $this->getCategory();
    }

    public function getCategory()
    {
        $this->categories = Category::all();
    }

    public function sync(JurnalApi $jurnalApi)
    {
        Category::sync($jurnalApi);
        $this->getCategory();
    }


    public function render()
    {
        return view('livewire.category-index')->layout('components.layouts.app', ['title' => "Categories"]);
    }
}
