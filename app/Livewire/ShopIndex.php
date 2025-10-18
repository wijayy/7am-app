<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Services\JurnalApi;
use App\Services\JurnalApiResponse;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ShopIndex extends Component
{
    use WithPagination;
    public $filter = false, $response;

    protected $jurnalApi;

    #[Url(except: '')]
    public $search = '', $freshness = '', $min = '', $max = '';

    public function mount(JurnalApi $jurnalApi)
    {
        $this->jurnalApi = $jurnalApi;

        $this->response = $this->jurnalApi->request('GET', '/public/jurnal/api/v1/products?&per_page=1000');

    }

    public function resetFilter()
    {
        // $this->category = '';
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

        if (isset($this->response['products'])) {
            $products = new JurnalApiResponse(collect($this->response['products'] ?? []));
            $products = $products->filteredProducts(['search' => $this->search, 'min' => $this->min, 'max' => $this->max])->orderBy('product_code')->paginate(24);
        } else {
            $products = [];
        }

        return view('livewire.shop-index', compact('products'))->layout('components.layouts.app.header', ['title' => "Shop"]);
    }
}
