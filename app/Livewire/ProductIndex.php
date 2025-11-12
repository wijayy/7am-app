<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\JurnalApi;
use App\Models\Category;
use App\Services\JurnalApiResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductIndex extends Component
{
    public $title = 'All Product';

    protected $jurnalApi;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: 1)]
    public $page = 1;

    #[Url(except: 50)]
    public $per_page = 50;


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


    public function render()
    {
        $products = Product::filters(['search' => $this->search])->paginate($this->per_page)->withQueryString();

        // dd($products);

        return view('livewire.product-index', compact('products'))->layout('components.layouts.app', ['title' => 'All Product']);
    }
}
