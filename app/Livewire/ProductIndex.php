<?php

namespace App\Livewire;

use App\Services\JurnalApi;
use App\Services\JurnalApiResponse;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductIndex extends Component
{
    public $title = 'All Product';

    protected $jurnalApi;

    #[Url(except: '')]
    public $search = '', $page = 1, $per_page = 50;

    public function mount(JurnalApi $jurnalApi)
    {
        $this->jurnalApi = $jurnalApi;
    }

    public function render()
    {
        $response = $this->jurnalApi->request('GET', '/public/jurnal/api/v1/products?&per_page=1000');

        if (isset($response['products'])) {
            $products = new JurnalApiResponse(collect($response['products'] ?? []));
            $products = $products->filteredProducts()->orderBy('product_code')->paginate(25);
        } else {
            $products = [];
        }

        // dd($products);

        return view('livewire.product-index', compact('products'))->layout('components.layouts.app', ['title' => 'All Product']);
    }
}
