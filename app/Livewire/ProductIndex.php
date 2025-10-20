<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\JurnalApi;
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
        $this->jurnalApi = $jurnalApi;
        // dd($this->jurnalApi);
        $response = $this->jurnalApi->request('GET', '/public/jurnal/api/v1/products?&per_page=1000');

        if (isset($response['products'])) {
            $products = new JurnalApiResponse(collect($response['products'] ?? []));
            $products = $products->filteredProducts()->get();
        } else {
            $products = [];
        }

        try {
            DB::beginTransaction();

            foreach ($products as $key => $item) {
                // simpan ke database lokal
                Product::updateOrCreate(
                    ['jurnal_id' => $item['id']],
                    [
                        'product_code' => $item['product_code'],
                        'name' => $item['name'],
                        'image' => $item['image']['url'],
                        'description' => $item['description'] ?? '',
                        'price' => $item['sell_price_per_unit'] ?? 0,
                        'unit' => $item['unit']['name'] ?? '',
                        'moq' => $item['moq'] ?? 1,
                        'active' => $item['active'] ?? true,
                    ]
                );
            }

            DB::commit();
            session()->flash('success', 'Products synchronized successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            return back()->with('error', '');
        }
    }

    public function render()
    {
        $products = Product::filters(['search' => $this->search])->paginate($this->per_page);

        // dd($products);

        return view('livewire.product-index', compact('products'))->layout('components.layouts.app', ['title' => 'All Product']);
    }
}