<?php

namespace App\Exports;

use App\Models\Transaction;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithHeadings, WithMapping
{
    public $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        return Transaction::with(['transactionItems.product', 'business', 'payment'])
            ->when($this->search, function ($query) {
                $query->where('number', 'like', "%{$this->search}%");
            })
            ->get()
            ->flatMap(function ($transaction) {
                return $transaction->transactionItems->map(function ($item) use ($transaction) {
                    return [
                        'invoice_number' => $transaction->number,
                        'business_name' => $transaction->business->name ?? '',
                        'product_sku' => $item->product->sku ?? '',
                        'product_name' => $item->product->name ?? '',
                        'qty' => $item->qty,
                        'price' => $item->price,
                        'subtotal' => $item->subtotal,
                        'total_transaction' => $transaction->total,
                        'status' => $transaction->status,
                        'payment_status' => $transaction->payment->payment_status ?? '',
                        'payment_amount' => $transaction->payment->amount ?? '',
                        'shipping_date' => $transaction->shipping_date,
                    ];
                });
            });
    }

    public function headings(): array
    {
        return [
            'Invoice Number',
            'Business Name',
            'Product SKU',
            'Product Name',
            'Qty',
            'Price',
            'Subtotal',
            'Total Transaction',
            'Status',
            'Payment Status',
            'Payment Amount',
            'Shipping Date',
        ];
    }

    public function map($row): array
    {
        return [
            $row['invoice_number'],
            $row['business_name'],
            $row['product_sku'],
            $row['product_name'],
            $row['qty'],
            $row['price'],
            $row['subtotal'],
            $row['total_transaction'],
            $row['status'],
            $row['payment_status'],
            $row['payment_amount'],
            $row['shipping_date'],
        ];
    }
}
