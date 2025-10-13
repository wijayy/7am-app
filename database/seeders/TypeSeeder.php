<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member = [
            [
                'name' => 'Silver',
                'minimum_point' => 0,
                'card' => "card/black-card.jpg"
            ],
            [
                'name' => 'Gold',
                'minimum_point' => 500,
                'card' => 'card/gold-card.jpg'
            ],
            [
                'name' => 'Platinum',
                'minimum_point' => 1500,
                'card' => 'card/red-card.jpg'
            ],
        ];

        foreach ($member as $key => $item) {
            Type::create($item);
        }
    }
}
