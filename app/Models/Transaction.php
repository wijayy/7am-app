<?php

namespace App\Models;

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
            $lastNumber = (int) substr($lastTransaction->number, -4);
            $nextNumber = $lastNumber + 1;
        }

        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $prefix . $formattedNumber;
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
