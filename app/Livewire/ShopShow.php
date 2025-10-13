<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShopShow extends Component
{
    public $product, $products, $qty;

    public function mount($slug)
    {
        try {
            DB::beginTransaction();
            $this->product = Product::where('slug', $slug)->firstOrFail();
            $this->products = Product::whereNot('slug', $slug)->take(3)->get();
            $this->qty = $this->product->moq;
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
        return view('livewire.shop-show')->layout('components.layouts.app.header', ['title' => $this->product->name]);
    }
}
