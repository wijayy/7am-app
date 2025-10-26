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
        if ($user && $user->bussinesses && $user->bussinesses?->setCategory) {
            // Ambil category dari setCategory milik bussiness pertama user
            $this->categories = $user->bussinesses->setCategory->category ?? collect();
        } else {
            // Fallback: ambil setCategory dari setting default
            $defaultSetCategoryId = Setting::where('key', 'default_set_category')->value('value');
            $setCategory = SetCategory::find($defaultSetCategoryId);
            $this->categories = $setCategory?->category ?? collect();
        }
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
        $products = Product::filters([
            'search' => $this->search,
            'min' => $this->min,
            'max' => $this->max,
            'set_category' => Auth::user()?->bussinesses?->setCategory->id
        ])->paginate(24)->withQueryString();

        return view('livewire.shop-index', compact('products'))->layout('components.layouts.app.header', ['title' => "Shop"]);
    }
}