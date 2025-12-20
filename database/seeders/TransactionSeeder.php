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
        $user = User::first();

        foreach (range(1, 5) as $key => $item) {
            $transaction = Transaction::factory(1)->create([
                'user_id' => $user->id,
            ]);
            $transaction = $transaction->first();
            foreach (range(1, mt_rand(1, 5)) as $key => $itm) {
                $product = Product::inRandomOrder()->first();
                $qty = mt_rand(1, 5);
                $subtotal = $product->price * $qty;

                TransactionItem::factory()->recycle($product, $transaction)->create([
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                    'price' => $product->price,
                ]);
            }

            $shipping = $user->addresses()->inRandomOrder()->first();

            // dd($shipping);

            Shipping::create([
                'user_id' => $user->id,
                'transaction_id' => $transaction->id,
                'type' => 'delivery',
                'address' => $shipping->address,
                'name' => $shipping->name,
                'phone' => $shipping->phone,
                'email' => $user->email,
            ]);

            // dd($transaction->items);
            $total = $transaction->items->sum('subtotal');

            $transaction->update(['total' => $total, 'packaging_fee' => $total * 0.03]);
        }
    }
}
