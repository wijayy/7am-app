<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Bussiness;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\RedeemPoint;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        foreach (range(1, 10) as $key => $item) {
            $user = User::factory()->create(['business' => 'requested', 'email' => "user{$item}@admin.com"]);

            Bussiness::factory()->recycle($user)->create();
        }

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'role' => 'admin'
        ]);

        Address::factory(3)->recycle($user)->create();

        foreach (range(1, 3) as $key => $item) {
            Category::factory(1)->create(['name' => "cat$item"]);
        }
        // foreach (range(1, 40) as $key => $item) {
        //     Product::factory(1)->recycle(Category::all())->create(['name' => "product $item"]);
        // }

        // Cart::factory(3)->recycle([$user, Product::all()])->create();

        $this->call(NewsletterSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(OutletSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(OutletImageSeeder::class);

        $this->call(ReservationSeeder::class);
        $this->call(OutletReviewSeeder::class);


        foreach (Outlet::all() as $key => $item) {
            $name = strtolower(array_reverse(explode(' ', $item->name))[0]);
            User::factory()->create([
                'name' => "Admin $name",
                'email' => "$name@admin.com",
                'role' => 'outlet-admin',
                'outlet_id' => $item->id
            ]);
        }

        $this->call(CardSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(MemberSeeder::class);

        $this->call(SettingSeeder::class);

        $this->call(RedeemPointSeeder::class);
    }
}