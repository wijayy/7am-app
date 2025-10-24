<?php

namespace App\Livewire;

use App\Models\Category;
use App\Services\JurnalApi;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CategoryIndex extends Component
{

    public $categories;
    protected $jurnalApi;

    public function mount()
    {
        $this->getCategory();
    }

    public function getCategory()
    {
        $this->categories = Category::all();
    }

    public function sync(JurnalApi $jurnalApi)
    {
        $this->jurnalApi = $jurnalApi;
        $response = $jurnalApi->request('GET', '/public/jurnal/api/v1/product_categories');

        $jurnalCategories = [];
        if (isset($response['product_categories'])) {
            $jurnalCategories = $response['product_categories'];
        }

        try {
            DB::beginTransaction();

            // 1. Ambil semua ID dari Jurnal
            $jurnalIds = array_column($jurnalCategories, 'id');

            // 2. Hapus kategori lokal yang tidak ada lagi di Jurnal
            // Pastikan hanya menghapus yang memiliki jurnal_id
            Category::whereNotNull('jurnal_id')->whereNotIn('jurnal_id', $jurnalIds)->delete();

            // 3. Update atau buat kategori baru dari data Jurnal
            foreach ($jurnalCategories as $item) {
                Category::updateOrCreate(
                    ['jurnal_id' => $item['id']],
                    ['name' => $item['name']]
                );
            }

            DB::commit();

            // Muat ulang data kategori dari database lokal dan kirim pesan sukses
            $this->getCategory();
            session()->flash('success', 'Categories have been successfully synchronized.');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            session()->flash('error', 'Failed to synchronize categories: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.category-index')->layout('components.layouts.app', ['title' => "Categories"]);
    }
}
