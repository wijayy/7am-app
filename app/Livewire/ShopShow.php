<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use App\Services\JurnalApi;
use App\Services\JurnalApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShopShow extends Component
{
    public $product, $products = [], $qty = 1;

    protected $jurnalApi;

    public function mount(JurnalApi $jurnalApi, $slug)
    {
        try {
            DB::beginTransaction();
            $this->jurnalApi = $jurnalApi;
            $this->product = $this->jurnalApi->request('GET', '/public/jurnal/api/v1/products/' . $slug);
            $this->product = $this->product['product'];
            // $this->products = Product::whereNot('slug', $slug)->take(3)->get();
            // $this->qty = $this->product->moq;

            // ambil daftar produk (page besar) untuk bahan rekomendasi
            $all = $this->jurnalApi->request('GET', '/public/jurnal/api/v1/products?&per_page=1000');
            $productsCollection = collect($all['products'] ?? []);

            // dapatkan rekomendasi (mengembalikan Collection)
            $recommender = new JurnalApiResponse($productsCollection);
            $this->products = $recommender->recommendations($this->product, 4)->all();
            dd($this->product);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }
    public function addToCart()
    {
        try {
            $cart = Cart::where('user_id', Auth::user()->id)->where('product_id', $this->product->id)->firstOrFail();

            $cart->increment('qty', $this->qty);
            $this->dispatch('updated');
        } catch (\Throwable $th) {
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $this->product->id,
                'qty' => $this->qty
            ]);
            $this->dispatch('created');
        }

        $this->qty = $this->product->moq;
    }
    public function render()
    {
        return view('livewire.shop-show')->layout('components.layouts.app.header', ['title' => $this->product['name']]);
    }
}
