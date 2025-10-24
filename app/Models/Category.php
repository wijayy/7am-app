<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
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
                'source' => 'name'
            ]
        ];
    }

    protected $guarded = ['id'];
    protected $with = ['products'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'jurnal_id');
    }

    public function setCategories()
    {
        return $this->belongsToMany(SetCategory::class, 'set_category_items');
    }
}
