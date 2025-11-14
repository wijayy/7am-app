<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        Coupon::create([
            'code' => 'WELCOME100',
            'type' => 'fixed',
            'amount' => 100000, // Rp100.000
            'limit' => 50,
            'minimum' => 0,
            'maximum' => null,
            'start_time' => $now,
            'end_time' => $now->copy()->addMonths(3),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        Coupon::create([
            'code' => 'SAVE10',
            'type' => 'percentage',
            'amount' => 10, // 10%
            'limit' => 200,
            'minimum' => 500000, // minimal order Rp500.000
            'maximum' => 200000, // maksimal diskon Rp200.000
            'start_time' => $now,
            'end_time' => $now->copy()->addMonths(6),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        Coupon::create([
            'code' => 'FREESHIP50',
            'type' => 'fixed',
            'amount' => 50000, // potongan ongkir Rp50.000
            'limit' => 100,
            'minimum' => 100000, // minimal belanja Rp100.000
            'maximum' => 50000,
            'start_time' => $now,
            'end_time' => $now->copy()->addMonth(),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
