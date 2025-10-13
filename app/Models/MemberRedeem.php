<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRedeem extends Model
{
    /** @use HasFactory<\Database\Factories\MemberRedeemFactory> */
    use HasFactory;


    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function redeem_point()
    {
        return $this->belongsTo(RedeemPoint::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

}
