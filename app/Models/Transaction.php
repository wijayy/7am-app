<?php

namespace App\Models;

use App\Services\JurnalApi;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'onUpdate' => true,
                'source' => 'transaction_number'
            ]
        ];
    }
    protected $guarded = ['id'];
    protected $with = ['items'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'shipping_date' => 'datetime',
        ];
    }

    public static function transactionNumberGenerator()
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = 'TRX' . $date;

        // Hitung jumlah transaksi yang sudah ada hari ini
        $lastTransaction = self::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->transaction_number, -4);
            $nextNumber = $lastNumber + 1;
        }

        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $prefix . $formattedNumber;
    }

    public static function transactionNumberJurnal(JurnalApi $jurnalApi)
    {
        // Panggil method `call` dengan method POST, path, dan body
        $response = $jurnalApi->request(
            'GET',
            '/public/jurnal/api/v1/sales_invoices?page_size=1',
        );

        // Hitung jumlah transaksi yang sudah ada hari ini
        $lastTransaction = (int) $response['sales_invoices'][0]['transaction_no'];

        return $lastTransaction++;
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function usage()
    {
        return $this->hasOne(CouponUsage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(PaymentInvoice::class);
    }

    public function activePayment()
    {
        return $this->invoices()
            ->where('status', 'pending')
            ->where('expired_at', '>', now())
            ->latest()
            ->first();
    }

    public function hasActivePaymentLink(): bool
    {
        return $this->invoices()
            ->where('status', 'pending')
            ->where('expired_at', '>', now())
            ->exists();
    }

    public static function generateOrderId(): string
    {
        // Hitung jumlah payment yang sudah pernah dibuat
        $count = $this->invoices()->count() + 1;

        // Format order_id
        return sprintf('INV-%s-%s', $this->id, $count);
    }


    public function scopeFilters(Builder $query, array $filters)
    {
        $query->when($filters["date"] ?? date('Y-m-d'), function ($query, $search) {
            return $query->whereDate("shipping_date",  $search);
        });
    }

    public static function monthFormat()
    {
        $driver = DB::getDriverName();

        return $driver === 'sqlite'
            ? "strftime('%Y-%m', created_at)"    // SQLite
            : "DATE_FORMAT(created_at, '%Y-%m')"; // MySQL
    }

    public static function yearFormat()
    {
        $driver = DB::getDriverName();

        return $driver === 'sqlite'
            ? "strftime('%Y', created_at)"     // SQLite
            : "YEAR(created_at)";              // MySQL
    }

    public static function onlyMonthFormat()
    {
        $driver = DB::getDriverName();

        return $driver === 'sqlite'
            ? "strftime('%m', created_at)"     // SQLite
            : "MONTH(created_at)";             // MySQL
    }
}
