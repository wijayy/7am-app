<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\JurnalApi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionIndex extends Component
{
    #[Url(except: null)]
    public $date;
    public $transactions;

    public function mount()
    {
        $this->date = $this->date ?? date('Y-m-d');
        $this->transactions = $this->getTransaction();
    }

    public function getTransaction()
    {
        return Transaction::whereDate('shipping_date', $this->date)->get();
    }

    public function updateDate()
    {
        $this->transactions = $this->getTransaction();
        // dd($this->date);
    }

    public function export()
    {
        // Ambil data dari DB
        $items = TransactionItem::whereIn('transaction_id', $this->transactions->pluck('id'))
            ->get();

        // Load template
        $templatePath = storage_path('app/public/SalesInvoiceImportTemplateMCTDA.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $startRow = 2; // asumsi header di baris 1
        $row = $startRow;

        foreach ($items as $item) {
            $sheet->setCellValue("A{$row}", $item->invoice_number);
            $sheet->setCellValue("B{$row}", $item->date);
            $sheet->setCellValue("C{$row}", $item->customer_name);
            $sheet->setCellValue("D{$row}", $item->product_name);
            $sheet->setCellValue("E{$row}", $item->qty);
            $sheet->setCellValue("F{$row}", $item->price);
            $sheet->setCellValue("G{$row}", $item->payment_method);
            $sheet->setCellValue("H{$row}", $item->paid_amount);
            $row++;
        }

        // Download file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Sales_Export_' . now()->format('Ymd_His') . '.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }

    public function import(JurnalApi $jurnalApi, $id)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::where('id', $id)->first();

            // dd($transaction);

            if (!$transaction) {
                Session::flash('error', "Transaction not found");
                return;
            }

            if ($transaction->status != 'paid') {
                Session::flash('error', "Transaction status are $transaction->status");
                return;
            }

            $memo = $transaction->note;

            if ($transaction->shipping->type == 'delivery') {
                $memo .= "\nDelivery to {$transaction->shipping->name} - {$transaction->shipping->address}";
            } else {
                $memo .= "\nPick Up at {$transaction->shipping->name}";
            }

            $body = [
                "sales_invoice" => [
                    "transaction_date" => $transaction->created_at->format('Y-m-d'),
                    "transaction_lines_attributes" => [],
                    "shipping_date" => $transaction->shipping_date->format('Y-m-d'),
                    "shipping_price" => 0,
                    "shipping_address" => $transaction->shipping->address,
                    "is_shipped" => true,
                    "ship_via" => "ship",
                    "reference_no" =>  $transaction->transaction_number,
                    "tracking_no" => $transaction->transaction_number,
                    "address" => $transaction->user?->bussinesses->address ?? "dirumah",
                    "term_name" => $transaction->payment->payment_type,
                    "due_date" => $transaction->created_at->format('D-m-y'),
                    "deposit_to_name" => Setting::where('key', 'deposit_to_name')->value('value'),
                    "deposit" => 0,
                    "discount_unit" => $transaction->discount,
                    "witholding_account_name" => Setting::where('key', 'witholding_account_name')->value('value'),
                    "witholding_value" => (int) Setting::where('key', 'witholding_value')->value('value'),
                    "witholding_type" => Setting::where('key', 'witholding_type')->value('value'),
                    "discount_type_name" => "percent",
                    "warehouse_name" => Setting::where('key', 'warehouse_name')->value('value'),
                    "warehouse_code" => Setting::where('key', 'warehouse_code')->value('value'),
                    "person_name" => $transaction->user?->bussinesses->name ?? "Toko 1",
                    "tags" => [],
                    "email" => $transaction->shipping->email,
                    "transaction_no" => "",
                    "message" => $memo,
                    "memo" => $memo,
                    "custom_id" => "",
                    "source" => "Website B2B 7AM",
                    "use_tax_inclusive" => false,
                    "tax_after_discount" => true,
                ],
            ];

            foreach ($transaction->items as $key => $item) {
                $body['sales_invoice']['transaction_lines_attributes'][] = [
                    "quantity" => $item->qty,
                    "rate" => $item->price,
                    "discount" => 0,
                    "product_name" => $item->product->name,
                    "line_tax_id" => (int) Setting::where('key', 'line_tax_id')->value('value'),
                    "line_tax_name" => "Setting::where('key', 'line_tax_name')->value('value')"
                ];
            }

            $response = $jurnalApi->request(
                'POST',
                '/public/jurnal/api/v1/sales_invoices',
                $body
            );
            // return response()->json($response);
            // dd($response);
            // dd($response['sales_invoice']['transaction_no']);

            $transaction->update(['number' => $response['sales_invoice']['transaction_no']]);
            DB::commit();

            // dd($transaction);

            $body = [
                "receive_payment" => [
                    "transaction_date" => $transaction->created_at->format('Y-m-d'),
                    "records_attributes" => [
                        [
                            "transaction_no" => $transaction->number,
                            "amount" => $transaction->total,
                        ],
                    ],
                    "custom_id" => "ReceivePayment" . $transaction->number,
                    "payment_method_name" => Setting::where('key', 'payment_method_name')->value('value'),
                    "payment_method_id" => (int) Setting::where('key', 'payment_method_id')->value('value'),
                    "is_draft" => false,
                    "deposit_to_name" => Setting::where('key', 'payment_deposit_to_name')->value('value'),
                    "memo" => "Payment order $transaction->number",
                    "witholding_account_name" => Setting::where('key', 'payment_witholding_account_name')->value('value'),
                    "witholding_value" => (int) Setting::where('key', 'payment_witholding_value')->value('value'),
                    "witholding_type" => Setting::where('key', 'payment_witholding_type')->value('value'),
                ],
            ];

            $response1 = $jurnalApi->request(
                'POST',
                '/public/jurnal/api/v1/receive_payments',
                $body
            );

            // dd($response1, $response);
            Session::flash('success', "Successfully imported to Jurnal! Transaction number: $transaction->number.");
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            return back()->with('error', '');
        }
    }

    public function render()
    {
        return view('livewire.transaction-index');
    }
}
