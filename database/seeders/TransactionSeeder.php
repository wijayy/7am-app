<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::latest()->first();

        $transactions = Transaction::factory(5)->create([
            'user_id' => $user->id,
        ]);

        foreach ($transactions as $key => $item) {
            foreach (range(1, mt_rand(1, 5)) as $key => $itm) {
                $product = Product::inRandomOrder()->first();
                $qty = mt_rand(1, 5);
                $subtotal = $product->price * $qty;

                TransactionItem::factory()->recycle($product, $item)->create([
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                    'price' => $product->price,
                ]);
            }
            $total = $item->items->sum('subtotal');

            $item->update(['total' => $total, 'packaging_fee' => $total * 0.03]);
        }
    }
}
