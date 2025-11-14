<?php

namespace App\Livewire;

use App\Models\Coupon;
use Livewire\Component;

class CouponIndex extends Component
{

    public $coupons;

    public function mount()
    {
        $this->coupons = Coupon::all();
    }

    public function render()
    {
        return view('livewire.coupon-index')->layout('components.layouts.app', ['title' => "All Coupon"]);
    }
}
