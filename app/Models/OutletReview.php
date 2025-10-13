<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletReview extends Model
{
    /** @use HasFactory<\Database\Factories\OutletReviewFactory> */
    use HasFactory;

    public $guarded = ['id'];

    public function reservation() {
        return $this->belongsTo(Reservation::class);
    }
}
