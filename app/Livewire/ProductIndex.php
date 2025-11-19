<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\JurnalApi;
use App\Models\Category;
use App\Services\JurnalApiResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ProductIndex extends Component
{
    public $title = 'All Product', $id;

    protected $jurnalApi;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: 1)]
    public $page = 1;

    #[Url(except: 50)]
    public $per_page = 50;

    #[Validate('required')]
    public $name = '';

    #[Validate()]
    public $moq = 1;


    public function mount(JurnalApi $jurnalApi)
    {
        $this->jurnalApi = $jurnalApi;
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

        $this->dispatch('modal-show', name: 'set-moq');
    }

    public function save()
    {
        $this->validate();

        $product = Product::find($this->id);
        $product->moq = $this->moq;
        $product->save();

        $this->dispatch('modal-close', name: 'set-moq');
    }


    public function render()
    {
        $products = Product::filters(['search' => $this->search])->paginate($this->per_page)->withQueryString();

        // dd($products);

        return view('livewire.product-index', compact('products'))->layout('components.layouts.app', ['title' => 'All Product']);
    }
}
