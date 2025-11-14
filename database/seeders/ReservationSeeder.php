<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Outlet::all() as $key => $item) {
            foreach (range(1, 10) as $key => $value) {
                Reservation::create([
                    'user_id' => 1,
                    'outlet_id' => $item->id,
                    'section_id' => $item->sections->first()->id,
                    'name' => fake()->name(),
                    'phone' => fake()->phoneNumber(),
                    'pax' => mt_rand(1, 10),
                    'date' => Carbon::now()
                ]);
            }
        }
    }
}
