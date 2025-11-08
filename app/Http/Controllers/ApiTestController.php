<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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

        // Panggil method `call` dengan method POST, path, dan body
        $response = $this->jurnalApi->request(
            'GET',
            '/public/jurnal/api/v1/taxes',
        );
        return $response;
        return response()->json($response);

        // $number = Transaction::transactionNumberGenerator($this->jurnalApi);

        // dd($number);
    }
}
