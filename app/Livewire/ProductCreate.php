<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreate extends Component
{
    use WithFileUploads;

    public $slug, $categories, $title, $preview, $product;

    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|integer')]
    public $price = '';

    #[Validate('required')]
    public $category_id = '';

    #[Validate('file|image')]
    public $image = '';
    #[Validate('required|integer')]
    public $moq = '';

    #[Validate('required|string')]
    public $description = '';

    #[Validate('required|in:fresh,frozen')]
    public $freshness = 'fresh';
    #[Validate('required')]

    public $status = 'active';

    public function mount($slug = null)
    {
        if ($slug) {
            $product = Product::where('slug', $slug)->first();
            $this->product = $product->id;
            $this->name = $product->name;
            $this->category_id = $product->category_id;
            $this->price = $product->price;
            $this->description = $product->description;
            $this->moq = $product->moq;
            $this->freshness = $product->freshness;
            $this->status = $product->status;
            $this->title = "Edit $this->name";
            $this->preview = $product->image;
        } else {
            $this->title = "Add New Product";
        }

        $this->categories = Category::all();
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            if ($this->image != '') {
                // save image
                $path = $this->image->store('product');
            } else {
                $path = $this->preview;
            }
            // dd($this->image);

            $product = Product::updateOrCreate(['id' => $this->product], [
                'name' => $this->name,
                'image' => $path,
                'description' => $this->description,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'moq' => $this->moq,
                'status' => $this->status,
                'freshness' => $this->freshness,
            ]);

            // dd($product);

            DB::commit();
            if ($this->preview != "") {
                Storage::delete($this->preview);
            }
            return redirect(route('product.index'))->with('success', $this->product ? "$this->name has been successfully modified" : 'New product successfully added');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }


    public function render()
    {
        return view('livewire.product-create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
