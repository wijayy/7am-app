<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\JurnalApi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
        Category::sync($this->jurnalApi);
    }
}
