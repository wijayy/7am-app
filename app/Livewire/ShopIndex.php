<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ShopIndex extends Component
{
    use WithPagination;
    public $categories, $category, $filter = false, $search, $freshness, $min, $max;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function resetFilter() {
        $this->category = '';
        $this->search = '';
        $this->min = '';
        $this->max = '';
        $this->freshness = '';
    }


    public function toogleFilter()
    {
        $this->filter = !$this->filter;
    }
    public function render()
    {
        $products = Product::filters(['freshness'=>$this->freshness, 'min'=>$this->min, 'max'=>$this->max, 'category'=>$this->category, 'search'=>$this->search])->paginate();


        return view('livewire.shop-index', compact('products'))->layout('components.layouts.app.header', ['title' => "Shop"]);
    }
}
