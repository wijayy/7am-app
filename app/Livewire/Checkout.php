<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CouponProduct;
use App\Models\CouponUsage;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{

    public $carts, $addresses, $address, $min, $shipping_date, $subtotal, $total, $discount = 0, $coupon;

    public function mount()
    {
        $this->carts = Cart::where('user_id', Auth::user()->id)->get();

        if ($this->carts->count() == 0) {
            return redirect(route('home'));
        }

        $this->addresses = Auth::user()->addresses;
        $this->address = $this->addresses->first();

        if (session()->has('coupon')) {
            $this->coupon = session('coupon');
        }
        // dd($this->coupon);

        $this->setMinShippingDate();

        $this->subtotal = 0;

        foreach ($this->carts as $key => $item) {
            $this->subtotal += $item->qty * $item->product->price;
        }

        $this->discount = $this->countDiscount();

        $this->total = $this->subtotal - $this->discount;
    }

    public function checkout()
    {
        try {
            DB::beginTransaction();


            DB::commit();
            Cart::where('user_id', Auth::user()->id)->delete();
            session(['coupon' => null]);
            return redirect(route('payment', ['slug' => $transaction->slug]));
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }

    public function setMinShippingDate()
    {
        $now = Carbon::now();

        if ($now->lt($now->copy()->setTime(17, 0))) {
            // sebelum jam 5 sore → minimal besok
            $this->min = $now->copy()->addDay()->toDateString();
        } else {
            // setelah jam 5 sore → minimal lusa
            $this->min = $now->copy()->addDays(2)->toDateString();
        }

        $this->shipping_date = $this->min;
    }

    public function changeAddress($id)
    {
        $this->address = Address::find($id);
        $this->dispatch('modal-close', ['name' => 'address']);
    }

    public function countDiscount()
    {
        if ($this->coupon ?? false) {
            if ($this->subtotal > $this->coupon->minimum) {
                if ($this->coupon->type == 'fixed') {
                    return $this->coupon->amount;
                } else {
                    $discount = 0;
                    foreach ($this->carts as $key => $item) {
                        $link = CouponProduct::where('coupon_id', $this->coupon->id)->where('product_id', $item->product->id)->first();

                        if ($link) {
                            $discount += $this->coupon->amount / 100 * $item->product->price * $item->qty;
                        }
                    }
                    if ($this->coupon->maximum > 0) {
                        $discount = min($discount, $this->coupon->maximum);
                    }
                    return $discount;
                }
            }
        }
        return 0;
    }

    public function render()
    {
        return view('livewire.checkout')->layout('components.layouts.app.header', ['title' => 'Checkout']);
    }
}
