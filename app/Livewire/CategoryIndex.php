<?php

namespace App\Livewire;

use App\Models\Category;
use App\Services\JurnalApi;
use Livewire\Component;

class CategoryIndex extends Component
{

    public $categories;
    protected $jurnalApi;

    public function mount(JurnalApi $jurnalApi)
    {
        $this->jurnalApi = $jurnalApi;
        $response = $jurnalApi->call('GET', '/public/jurnal/api/v1/product_categories');

        if (isset($response['product_categories'])) {
            $this->categories = $response['product_categories'];
        }

        // dd($this->categories);
    }

    public function render()
    {
        return view('livewire.category-index')->layout('components.layouts.app', ['title' => "Categories"]);
    }
}
