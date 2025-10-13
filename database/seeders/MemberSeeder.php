<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Member;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member = Type::where('slug', 'silver')->first();
        foreach (range(1, 20) as $key => $item) {
            Member::factory(1)->recycle([$member, Card::inRandomOrder()->first()])->create(
                ['email' => "Loyality$item@gmail.com"]
            );
        }
    }
}
