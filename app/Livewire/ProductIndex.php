<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\JurnalApi;
use App\Models\Category;
use App\Models\SetCategory;
use App\Services\JurnalApiResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProductIndex extends Component
{
    public $title = 'All Product', $id, $categories, $set_categories;

    protected $jurnalApi;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: '')]
    public $category = '';

    #[Url(except: '')]
    public $set_category = '';

    #[Url(except: 1)]
    public $page = 1;

    #[Url(except: 50)]
    public $per_page = 50;

    #[Validate('required')]
    public $name = '';

    #[Validate('required|integer')]
    public $moq = 1, $maximum_order = 0;

    #[Validate('required_unless:maximum_order, 0|nullable')]
    public $cutoff_time = '';

    public function mount(JurnalApi $jurnalApi)
    {
        $this->jurnalApi = $jurnalApi;

        $this->categories = Category::all();
        $this->set_categories = SetCategory::all();
    }

    public function updatedSearch()
    {
        // $this->resetPage();
    }

    public function sync(JurnalApi $jurnalApi)
    {
        Product::sync($jurnalApi);
    }

    public function setMOQ($id)
    {
        $this->id = $id;
        $product = Product::find($id);
        $this->name = $product->name;
        $this->moq = $product->moq ?? 1;
        $this->maximum_order = $product->maximum_order ?? 0;
        $this->cutoff_time = $product->cutoff_time;

        $this->dispatch('modal-show', name: 'set-moq');
    }

    public function save()
    {
        $this->validate();

        $product = Product::find($this->id);
        $product->moq = $this->moq;
        $product->maximum_order = $this->maximum_order;
        $product->cutoff_time = $this->cutoff_time;
        $product->save();

        $this->dispatch('modal-close', name: 'set-moq');
    }


    public function render()
    {

        $this->categories = $this->set_category == "" ? Category::all() : SetCategory::find($this->set_category)->categories;
        $products = Product::filters(['search' => $this->search, 'category' => $this->category, 'set_category' => $this->set_category])->paginate($this->per_page)->withQueryString();

        // dd($products);

        return view('livewire.product-index', compact('products'))->layout('components.layouts.app', ['title' => 'All Product']);
    }
}
