<?php

namespace App\Http\Controllers;

use App\Services\JurnalApi;
use Illuminate\Http\Request;

class ApiTestController extends Controller
{
    private $jurnalApi;

    public function __construct(JurnalApi $jurnalApi)
    {
        $this->jurnalApi = $jurnalApi;
    }

    public function index()
    {
        // Data body untuk membuat produk baru
        $productData = [
            "product_category" => [
                "name" => "Baju"
            ]
        ];

        $payload = [
            'sales_order' => [
                'transaction_date' => '2016-10-25',
                'transaction_lines_attributes' => [
                    [
                        'quantity' => 1,
                        'rate' => 12000000,
                        'discount' => 10,
                        'product_name' => 'Penjualan',
                        'line_tax_id' => 3198,
                        'line_tax_name' => 'ppn',
                    ],
                ],
                'shipping_date' => '2016-10-25',
                'shipping_price' => 0,
                'shipping_address' => 'Test Street',
                'is_shipped' => true,
                'ship_via' => 'ship',
                'reference_no' => 'TEST1234',
                'tracking_no' => 'TNO098',
                'address' => 'JL. Gatot Subroto 55, Jakarta, 11739',
                'term_name' => 'Cash on Delivery',
                'due_date' => '2016-10-25',
                'deposit_to_name' => 'Kas',
                'deposit' => 30000,
                'discount_unit' => 10,
                'discount_type_name' => 'Percent',
                'person_name' => 'TOKO 1',
                'warehouse_name' => 'warehouse 1',
                'warehouse_code' => null,
                'tags' => [
                    'Dina',
                ],
                'witholding_account_id' => 12344556,
                'witholding_value' => 10,
                'witholding_type' => 'percent',
                'email' => 'customer@example.com',
                'transaction_no' => 'INV-12345678',
                'message' => 'message goes here',
                'memo' => 'memo goes here',
                'custom_id' => 'order_tes',
                'tax_after_discount' => true,
            ],
        ];

        // Panggil method `call` dengan method POST, path, dan body
        $response = $this->jurnalApi->request(
            'POST',
            '/public/jurnal/api/v1/sales_orders',
            $payload
        );
        // return $response;
        return response()->json($response);
    }
}
