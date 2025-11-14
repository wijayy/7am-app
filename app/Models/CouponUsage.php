<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    /** @use HasFactory<\Database\Factories\CouponUsageFactory> */
    use HasFactory;

    public $guarded = ['id'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
