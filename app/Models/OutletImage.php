<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletImage extends Model
{
    /** @use HasFactory<\Database\Factories\OutletImageFactory> */
    use HasFactory;

    protected $guarded = ['id'];
}
