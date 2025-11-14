<?php

namespace Database\Seeders;

use App\Models\OutletReview;
use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Reservation::all() as $key => $item) {
            OutletReview::create([
                'reservation_id' => $item->id,
                'rate' => mt_rand(1, 5),
                'review' => fake()->sentence()
            ]);
        }
    }
}
