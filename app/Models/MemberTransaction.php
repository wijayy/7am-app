<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\MemberTransactionFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

        

}
