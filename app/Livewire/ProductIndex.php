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
        $this->jurnalApi = $jurnalApi;
        // dd($this->jurnalApi);
        $response = $this->jurnalApi->request('GET', '/public/jurnal/api/v1/products?&per_page=10000');

        if (isset($response['products'])) {
            $products = new JurnalApiResponse(collect($response['products'] ?? []));
            $products = $products->get();
        } else {
            $products = [];
        }

        try {
            DB::beginTransaction();

            // 1. Ambil semua ID produk dari Jurnal
            $jurnalProductIds = collect($products)->pluck('id')->toArray();

            // 2. Hapus produk lokal yang tidak ada lagi di Jurnal
            Product::whereNotNull('jurnal_id')->whereNotIn('jurnal_id', $jurnalProductIds)->delete();

            // 3. Ambil daftar Jurnal ID dari kategori yang aktif di database lokal
            $activeCategoryJurnalIds = Category::where('active', true)->pluck('jurnal_id')->toArray();

            Product::whereNotIn('category_id', $activeCategoryJurnalIds)->delete();

            // 4. Update atau buat produk baru dari data Jurnal
            foreach ($products as $key => $item) {
                // Dapatkan Jurnal ID kategori dari produk ini
                $productCategoryId = $item['product_categories'][0]['id'] ?? null;

                // Lanjutkan hanya jika kategori produk ada di daftar kategori aktif
                if ($productCategoryId && in_array($productCategoryId, $activeCategoryJurnalIds)) {
                    Product::updateOrCreate(
                        ['jurnal_id' => $item['id']],
                        [
                            'product_code' => $item['product_code'],
                            'name' => $item['name'],
                            'image' => $item['image']['url'] ?? null,
                            'description' => $item['description'] ?? '',
                            'price' => $item['sell_price_per_unit'] ?? 0,
                            'unit' => $item['unit']['name'] ?? '',
                            'moq' => $item['moq'] ?? 1,
                            'active' => $item['active'] ?? true,
                            'category_id' => $productCategoryId,
                        ]
                    );
                }
            }

            DB::commit();
            session()->flash('success', 'Products synchronized successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) {
                throw $th;
            }
            session()->flash('error', 'Failed to synchronize products: ' . $th->getMessage());
        }
    }

    public function render()
    {
        $products = Product::filters(['search' => $this->search])->paginate($this->per_page)->withQueryString();

        // dd($products);

        return view('livewire.product-index', compact('products'))->layout('components.layouts.app', ['title' => 'All Product']);
    }
}
