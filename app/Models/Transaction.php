<?php

namespace App\Models;

use App\Services\JurnalApi;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
                'source' => 'number'
            ]
        ];
    }
    protected $guarded = ['id'];

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

    public static function transactionNumberGenerator(JurnalApi $jurnalApi)
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

    public function scopeFilters(Builder $query, array $filters)
    {
        $query->when($filters["date"] ?? date('Y-m-d'), function ($query, $search) {
            return $query->whereDate("shipping_date",  $search);
        });
    }
}
