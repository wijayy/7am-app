<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first() ?? User::factory(),
            'transaction_number' => Transaction::transactionNumberGenerator(),
            'subtotal' => 0,
            'total' => 0,
            'discount' => 0,
            'packaging_fee' => 0,
            'status' => 'paid',
            'shipping_date' => date('Y-m-d'),
        ];
    }
}
