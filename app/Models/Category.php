<?php

namespace App\Models;

use App\Models\Product;
// use App\Models\Category;
use App\Models\SetCategory;
use App\Services\JurnalApi;
use App\Livewire\Test\Jurnal;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'onUpdate' => true,
                'source' => 'name'
            ]
        ];
    }

    protected $guarded = ['id'];
    protected $with = ['products'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'jurnal_id');
    }

    public function setCategories()
    {
        return $this->belongsToMany(
            SetCategory::class,          // model tujuan
            'set_category_items',        // tabel pivot
            'category_id',               // FK dari Category
            'set_category_id'            // FK dari SetCategory
        )
            ->select('set_categories.*'); // 👈 cegah konflik id
    }

    public static function sync(JurnalApi $jurnalApi)
    {
        $response = $jurnalApi->request('GET', '/public/jurnal/api/v1/product_categories?page_size=100');
        // dd($jurnalApi);
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
            self::whereNotNull('jurnal_id')->whereNotIn('jurnal_id', $jurnalIds)->delete();

            // 3. Update atau buat kategori baru dari data Jurnal
            foreach ($jurnalCategories as $item) {

                self::updateOrCreate(
                    ['jurnal_id' => $item['id']],
                    [
                        'name' => $item['name'],
                        'active' => true,
                    ]
                );
            }

            DB::commit();

            // Muat ulang data kategori dari database lokal dan kirim pesan sukses
            // $this->getCategory();
            session()->flash('success', 'Categories have been successfully synchronized.');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            session()->flash('error', 'Failed to synchronize categories: ' . $th->getMessage());
        }
    }
}
