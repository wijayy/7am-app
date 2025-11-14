<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loyality extends Model
{
    /** @use HasFactory<\Database\Factories\LoyalityFactory> */
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
                // build slug from code + name
                'source' => ['code', 'name']
            ]
        ];
    }

    // ensure model has guarded definition
    protected $guarded = ['id'];

    /**
     * Relationship: Loyality belongs to Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

}
