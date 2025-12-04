<?php

namespace Database\Seeders;

use App\Models\Bussiness;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 5) as $key => $value) {
            $user = User::factory()->create([
                'email' => "customer{$value}@admin.com",
                'role' => 'customer',
                'business' => 'requested',
            ]);

            Bussiness::factory()->create([
                'user_id' => $user->id,
                'status' => 'requested',
            ]);
        }
    }
}
