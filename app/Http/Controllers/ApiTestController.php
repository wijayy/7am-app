<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\JurnalApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTestController extends Controller
{
    private $jurnalApi;

    public function __construct(JurnalApi $jurnalApi)
    {
        $this->jurnalApi = $jurnalApi;
    }

    public function index()
    {
        // Gunakan MigrateSqliteToMysqlSeeder untuk migrasi data
        // Contoh: migrasi tabel users dari SQLite ke MySQL
        $transaction = Transaction::first();

        $transaction->delete();

        $transactions = Transaction::all();
        dd($transaction, $transactions);
    }
}
