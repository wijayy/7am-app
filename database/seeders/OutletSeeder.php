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
            // [
            //     'name' => "7AM Bakers | 7PM Dinners Ubud",
            //     'image' => "outlets/ubud.jpg",

            // ],
            // [
            //     'name' => "7AM Bakers | 7PM Dinners Pererenan",
            //     'image' => "outlets/pererenan.jpg",

            // ],
            // [
            //     'name' => "7AM Bakers Umalas",
            //     'image' => "outlets/umalas.jpg",

            // ],
            [
                'name' => "7AM Bakers Grand Indonesia",
                'image' => "outlets/grand_indonesia.jpg",
                'is_active' => false,

            ],
            [
                'name' => "7AM Bakers Margo City",
                'image' => "outlets/margo_city.jpg",
                'is_active' => false,

            ],
            [
                'name' => "7AM Bakers Senayan City",
                'image' => "outlets/senayan_city.jpg",
                'is_active' => false,
            ]
        ];

        foreach ($outlets as $key => $item) {
            Outlet::factory()->create($item);
        }
    }
}
