<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    /** @use HasFactory<\Database\Factories\CouponProductFactory> */
    use HasFactory;

    public $guarded = ['id'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
