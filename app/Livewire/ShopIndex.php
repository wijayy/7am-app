<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ShopIndex extends Component
{
    use WithPagination;
    public $filter = false;

    #[Url(except: '')]
    public $search = '', $min = '', $max = '';

    public function mount()
    {
        // dd($this->jurnalApi);
    }

    public function resetFilter()
    {
        // $this->category = '';
        $this->search = '';
        $this->min = '';
        $this->max = '';
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
        ])->where('active', true)->paginate(24)->withQueryString();

        return view('livewire.shop-index', compact('products'))->layout('components.layouts.app.header', ['title' => "Shop"]);
    }
}