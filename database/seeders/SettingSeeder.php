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
            [
                'key' => 'input_point',
                'value' => 'true',
                'type' => 'text',

            ],
            [
                'key' => "default_set_category",
                'value' => 1,
                'type' => 'number',

            ],
            [
                'key' => 'deposit_to_name',
                'value' => '',
                'type' => 'text',
            ],
            [
                'key' => 'witholding_account_name',
                'value' => '',
                'type' => 'text',
            ],
            [
                'key' => 'witholding_value',
                'value' => '',
                'type' => 'number',
            ],
            [
                'key' => 'witholding_type',
                'value' => '',
                'type' => 'text',
            ],
            [
                'key' => 'warehouse_name',
                'value' => '',
                'type' => 'text',
            ],
            [
                'key' => 'warehouse_code',
                'value' => '',
                'type' => 'text',
            ],
            [
                'key' => 'line_tax_id',
                'value' => '',
                'type' => 'number',
            ],
            [
                'key' => 'line_tax_name',
                'value' => '',
                'type' => 'text',
            ],

            // Receive Payment Settings
            [
                'key' => 'payment_method_name',
                'value' => '',
                'type' => 'text',
            ],
            [
                'key' => 'payment_method_id',
                'value' => '',
                'type' => 'number',
            ],
            [
                'key' => 'payment_deposit_to_name',
                'value' => '',
                'type' => 'text',
            ],
            [
                'key' => 'payment_witholding_account_name',
                'value' => '',
                'type' => 'text',
            ],
            [
                'key' => 'payment_witholding_value',
                'value' => '',
                'type' => 'number',
            ],
            [
                'key' => 'payment_witholding_type',
                'value' => '',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $key => $item) {
            Setting::create($item);
        }
    }
}
