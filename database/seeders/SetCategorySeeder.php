<?php

namespace Database\Seeders;

use App\Models\SetCategory;
use App\Models\SetCategoryItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SetCategory::create([
            'name' => 'Default'
        ]);

        SetCategoryItem::factory(2)->create();
    }
}
