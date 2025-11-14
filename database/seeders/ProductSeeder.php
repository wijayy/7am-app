<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\JurnalApi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    protected $jurnalApi;

    public function __construct(JurnalApi $jurnalApi)
    {
        $this->jurnalApi = $jurnalApi;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::sync($this->jurnalApi);
    }
}
