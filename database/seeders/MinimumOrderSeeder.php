<?php

namespace Database\Seeders;

use App\Models\MinimumOrder;
use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MinimumOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Village::all() as $key => $item) {
            MinimumOrder::factory()->create([
                'village_id' => $item->id,
            ]);
        }
    }
}
