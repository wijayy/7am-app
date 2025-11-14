<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class SetCategory extends Model
{
    /** @use HasFactory<\Database\Factories\SetCategoryFactory> */
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id'];
    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }

    public function items()
    {
        return $this->hasMany(SetCategoryItem::class);
    }

    /**
     * The categories that belong to the SetCategory
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,             // model tujuan
            'set_category_items',        // tabel pivot
            'set_category_id',           // FK dari SetCategory
            'category_id'                // FK dari Category
        )
            ->select('categories.*'); // 👈 cegah "ambiguous column id"
    }
}