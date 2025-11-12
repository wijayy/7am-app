<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetCategoryItem extends Model
{
    /** @use HasFactory<\Database\Factories\SetCategoryItemFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the setCategory that owns the SetCategoryItem
     */
    public function setCategory()
    {
        return $this->belongsTo(SetCategory::class);
    }

    /**
     * Get the category that owns the SetCategoryItem
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
