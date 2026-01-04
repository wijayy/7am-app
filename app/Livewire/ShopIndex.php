<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\SetCategory;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ShopIndex extends Component
{
    use WithPagination;
    public $filter = false, $categories;

    #[Url(except: '')]
    public $search = '', $min = '', $max = '';

    #[Url(except: '')]
    public $category = '';

    public function mount()
    {
        $user = Auth::user();

        // Jika user login, punya relasi bussinesses, dan relasi setCategory pada salah satu bussinesses
        if ($user && $user->bussinesses && $user->bussinesses->setCategory) {
            // Jika user punya bisnis dan bisnis itu punya setCategory
            $this->categories = $user->bussinesses?->setCategory?->categories ?? collect();

            // dd(true, $this->categories);
        } else {
            // Jika tidak, gunakan set category default dari setting
            $defaultSetCategoryId = Setting::where('key', 'default_set_category')->value('value');
            $defaultSetCategory = SetCategory::find($defaultSetCategoryId);

            $this->categories = $defaultSetCategory->categories ?? collect();
            // dd(false, $this->categories, $defaultSetCategory);
        }

        // dd(Auth::user()?->bussinesses?->setCategory->id);
    }

    public function resetFilter()
    {
        // $this->category = '';
        $this->search = '';
        $this->min = '';
        $this->max = '';
        $this->category = '';
    }

    public function openShowModal($jurnal_id)
    {
        $this->dispatch('showModal', jurnal_id: $jurnal_id);
    }

    public function toogleFilter()
    {
        $this->filter = !$this->filter;
    }

    public function render()
    {
        // Ambil set_category terbaru langsung dari DB (menghindari relasi Auth yang stale)
        $setCategoryId = null;
        if (Auth::check()) {
            $setCategoryId = \App\Models\Bussiness::where('user_id', Auth::id())->value('set_category_id');
        }
        $setCategoryId = $setCategoryId ?? Setting::where('key', 'default_set_category')->value('value');

        // Perbarui daftar kategori berdasarkan set_category yang aktif
        $this->categories = SetCategory::find($setCategoryId)?->categories ?? collect();

        $products = Product::filters([
            'search' => $this->search,
            'category' => $this->category,
            'min' => $this->min,
            'max' => $this->max,
            'set_category' => $setCategoryId
        ])->paginate(24)->withQueryString();

        return view('livewire.shop-index', compact('products'))->layout('components.layouts.app.header', ['title' => "Shop"]);
    }
}
