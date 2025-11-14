<?php

namespace Database\Seeders;

use App\Models\RedeemPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RedeemPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $redeem = [
            [
                'name' => "Redeem 100 Points",
                'reward' => "Voucher Rp. 50.000",
                'point' => 100
            ],
            [
                'name' => "Redeem 300 Points",
                'reward' => "Free Speciality Coffee or Pastry",
                'point' => 300
            ],
            [
                'name' => "Redeem 500 Points",
                'reward' => "Voucher Rp. 250.000",
                'point' => 500
            ],
            [
                'name' => "Redeem 1500 Points",
                'reward' => "Exclusive Dinner for 2 or Private Event Invitation",
                'point' => 1500
            ],
            [
                'name' => "Birthday Reward",
                'reward' => "Free Dessert or Drink",
                'point' => 0
            ],
        ];

        foreach ($redeem as $key => $item) {
            RedeemPoint::create($item);
        }
    }
}
