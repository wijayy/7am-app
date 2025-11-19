<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = [
            [
                'name' => "7AM Bakers | 7PM Dinners Ubud",
                'image' => "outlets/ubud.jpg",

            ],
            [
                'name' => "7AM Bakers | 7PM Dinners Pererenan",
                'image' => "outlets/pererenan.jpg",

            ],
            [
                'name' => "7AM Bakers Umalas",
                'image' => "outlets/umalas.jpg",

            ]
        ];

        foreach ($outlets as $key => $item) {
            Outlet::factory()->create($item);
        }
    }
}
