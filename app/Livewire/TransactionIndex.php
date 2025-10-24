<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\TransactionItem;
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
        return Transaction::where('shipping_date', $this->date)->get();
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

    public function render()
    {
        return view('livewire.transaction-index');
    }
}
