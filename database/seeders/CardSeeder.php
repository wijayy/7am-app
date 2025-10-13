<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = [
            [
                'name' => 'Black Card',
                'card' => 'card/black-card.jpg',
                'discount' => 10,
                'discount_type' => 'Food Only',
                'usage' => 'Foreign Tourist/Expat'
            ],
            [
                'name' => 'Red Card',
                'card' => 'card/red-card.jpg',
                'discount' => 10,
                'discount_type' => 'Food Only',
                'usage' => 'Local Tourist'
            ],
            [
                'name' => 'Gold Card',
                'card' => 'card/gold-card.jpg',
                'discount' => 35,
                'discount_type' => 'Food and Non Alcoholic',
                'usage' => 'Friends and Family of Owner'
            ],
        ];

        foreach ($cards as $key => $item) {
            Card::create($item);
        }
    }
}
