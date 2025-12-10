<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // [
            //     'key' => 'input_point',
            //     'value' => 'true',
            //     'type' => 'text',

            // ],
            // [
            //     'key' => "default_set_category",
            //     'value' => 1,
            //     'type' => 'number',

            // ],
            // [
            //     'key' => 'deposit_to_name',
            //     'value' => 'BCA  Airport Bakery Service',
            //     'type' => 'text',
            // ],
            // [
            //     'key' => 'witholding_account_name',
            //     'value' => 'Deposit In Transit B2B',
            //     'type' => 'text',
            // ],
            // [
            //     'key' => 'witholding_value',
            //     'value' => '0',
            //     'type' => 'number',
            // ],
            // [
            //     'key' => 'witholding_type',
            //     'value' => 'value',
            //     'type' => 'text',
            // ],
            // [
            //     'key' => 'warehouse_name',
            //     'value' => '',
            //     'type' => 'text',
            // ],
            // [
            //     'key' => 'warehouse_code',
            //     'value' => '',
            //     'type' => 'text',
            // ],
            // [
            //     'key' => 'line_tax_id',
            //     'value' => '1047236',
            //     'type' => 'number',
            // ],
            // [
            //     'key' => 'line_tax_name',
            //     'value' => 'Packaging and Handling',
            //     'type' => 'text',
            // ],

            // // Receive Payment Settings
            // [
            //     'key' => 'payment_method_name',
            //     'value' => 'Bank Transfer',
            //     'type' => 'text',
            // ],
            // [
            //     'key' => 'payment_method_id',
            //     'value' => '3082237',
            //     'type' => 'number',
            // ],
            // [
            //     'key' => 'payment_deposit_to_name',
            //     'value' => 'BCA  Airport Bakery Service',
            //     'type' => 'text',
            // ],
            // [
            //     'key' => 'payment_witholding_account_name',
            //     'value' => '',
            //     'type' => 'text',
            // ],
            // [
            //     'key' => 'payment_witholding_value',
            //     'value' => '0',
            //     'type' => 'number',
            // ],
            // [
            //     'key' => 'payment_witholding_type',
            //     'value' => 'value',
            //     'type' => 'text',
            // ],
            [
                'key' => 'tax_after_discount',
                'value' => 'true',
                'type' => 'text',
            ],
            [
                'key' => 'use_tax_inclusive',
                'value' => 'true',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $key => $item) {
            Setting::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
