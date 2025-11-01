<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinimumOrder extends Model
{
    /** @use HasFactory<\Database\Factories\MinimumOrderFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
