<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function success(Request $request)
    {
        try {
            logger()->info('Midtrans callback data:', $request->all());

            $orderId = $request->input('order_id');
            $statusCode = $request->input('status_code');
            $transactionStatus = $request->input('transaction_status');

            $booking = Transaction::where('number', $orderId)->first();

            if (!$booking) {
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                Payment::create(['transaction_id'=>$booking->id, 'amount'=>$booking->total, 'payment_status'=>'paid']);
                $booking->update(['status'=>'paid']);
            }

            return response()->json(['message' => 'Pembayaran berhasil diterima']);
        } catch (\Exception $e) {
            logger()->error('Midtrans callback error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }
}
