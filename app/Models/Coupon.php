<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory, Sluggable, SoftDeletes;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                                'onUpdate' =>true,
                'source' => 'code'
            ]
        ];
    }

    public $guarded = ['id'];

    public function usage()
    {
        return $this->hasMany(CouponUsage::class);
    }
    public function links()
    {
        return $this->hasMany(CouponProduct::class);
    }

    public function products()
{
    return $this->belongsToMany(Product::class, 'coupon_products');
}

    public function is_active()
    {
        $now = Carbon::now();

        // Kupon tidak aktif kalau sudah lewat masa berlaku
        if ($this->start_time && $now->lt(Carbon::parse($this->start_time))) {
            return false;
        }

        if ($this->end_time && $now->gt(Carbon::parse($this->end_time))) {
            return false;
        }

        // Kupon tidak aktif kalau sudah melebihi batas penggunaan
        if ($this->limit !== null && $this->usage->count() >= $this->limit) {
            return false;
        }

        return true;
    }

    public function casts(){
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }
}
