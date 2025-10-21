<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
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
                'onUpdate' => true,
                'source' => [
                    'product_code',
                    'name'
                ]
            ]
        ];
    }

    protected $guarded = ['id'];
    protected $perPage = 12;

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'jurnal_id');
    }

    public function links()
    {
        return $this->hasMany(CouponProduct::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, CouponProduct::class);
    }

    public function scopeFilters(Builder $query, array $filters)
    {
        $query->when($filters["search"] ?? false, function ($query, $search) {
            return $query->where("name", "like", "%$search%")->orwhere("product_code", "like", "%$search%");
        });

        $query->when($filters["min"] ?? false, function ($query, $search) {
            return $query->where("price", ">", "$search");
        });

        $query->when($filters["max"] ?? false, function ($query, $search) {
            return $query->where("price", "<", "$search");
        });
    }

    public static function skuNumberGenerator()
    {
        $prefix = 'SKU-';

        // Hitung jumlah produk yang sudah
        $lastTransaction = self::orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->sku, -4);
            $nextNumber = $lastNumber + 1;
        }

        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $prefix . $formattedNumber;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        return asset('assets/No-Picture-Found.png');
    }
}