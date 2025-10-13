<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    /** @use HasFactory<\Database\Factories\NewsletterFactory> */
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

    protected $with = ['reservations', 'sections', 'images', 'reviews'];

    protected $guarded = ['id'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function images()
    {
        return $this->hasMany(OutletImage::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(OutletReview::class, Reservation::class);
    }



    // ...existing code...
    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];
    // ...existing code...
}
