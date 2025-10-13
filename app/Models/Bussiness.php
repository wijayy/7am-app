<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bussiness extends Model
{
    /** @use HasFactory<\Database\Factories\BussinessFactory> */
    use HasFactory;

    public $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
