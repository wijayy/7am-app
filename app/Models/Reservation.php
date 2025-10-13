<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;

    public $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function review()
    {
        return $this->hasOne(OutletReview::class);
    }

    protected $casts = [
        'date' => 'datetime',
    ];

    public function scopeFilters(Builder $query, array $filters)
    {
        $query->when($filters["date"] ?? date('Y-m-d'), function ($query, $search) {
            return $query->whereDate("date", $search);
        });

        // Filter jika user login punya relasi ke outlet tertentu
        if (Auth::check() && Auth::user()->outlet_id ?? false) {
            $outletId = Auth::user()->outlet_id;
            $query->whereHas('outlet', function ($q) use ($outletId) {
                $q->where('id', $outletId);
            });
        }


    }
}
