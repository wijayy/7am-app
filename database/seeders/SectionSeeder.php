<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                ['name' => 'Indoor 1st Floor'],
                ['name' => 'Indoor 2nd Floor'],
                ['name' => 'Outdoor 2nd Floor'],
                ['name' => 'Garden'],
            ],
            [
                ['name' => 'Indoor'],
                ['name' => 'Outdoor'],
            ],
            [
                ['name' => 'Indoor 1st Floor'],
                ['name' => 'Indoor 2st Floor'],
                ['name' => 'Outdoor 1nd Floor'],
                ['name' => 'Outdoor 2nd Floor'],
            ],

        ];

        foreach (Outlet::where('is_active', true)->get() as $key => $item) {
            $item->sections()->createMany($sections[$item->id - 1]);
        }
    }
}
