<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\OutletImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Outlet::all() as $key => $item) {
            foreach (range(1, 20) as $key1 => $value1) {
                OutletImage::create([
                    'outlet_id' => $item->id,
                    'image' => 'outlets/image.jpg',
                ]);
            }
        }
    }
}
