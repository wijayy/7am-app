<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ProductIndex extends Component
{
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($id);
            $image = $product->image;

            $product->delete();
            DB::commit();
            Storage::delete($image);
            $this->dispatch('modal-close');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }

    }

    public function render()
    {
        $product = Product::latest()->paginate(24);

        return view('livewire.product-index', compact('product'))->layout('components.layouts.app', ['title' => 'All Product']);
    }
}
