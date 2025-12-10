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
            if ($item->district->regency->name == "Denpasar") {
                $minimum = 1000000;
            } elseif ($item->district->name == "Ubud") {
                $minimum = 1000000;
            } elseif (in_array($item->district->name, ["Tabanan", "Kediri", 'Mengwi', 'Abiansemal', 'Petang'])) {
                $minimum = 300000;
            } elseif (in_array($item->district->name, ["Kuta Selatan"])) {
                $minimum = 1000000;
            }
            if (in_array($item->name, ['Sanur', 'Sanur Kauh', 'Sanur Kaja', "Kuta", "Legian"])) {
                $minimum = 400000;
            }
            if (in_array($item->name, ['Seminyak'])) {
                $minimum = 300000;
            }

            if (in_array($item->name, ['Canggu'])) {
                $minimum = 200000;
            }

            MinimumOrder::updateOrInsert(
                ['village_id' => $item->id],
                ['minimum' => $minimum ?? 0]
            );
        }
    }
}
