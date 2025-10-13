<?php

namespace App\Livewire;

use App\Models\Cart as ModelsCart;
use App\Models\Coupon;
use App\Models\CouponProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cart extends Component
{
    public $carts, $qty, $subtotal, $coupon, $cpn = false, $c, $message;

    public function mount()
    {
        $this->carts();

    }
    public function checkout()
    {
        sleep(2);

        if ($this->carts->count() == 0) {
            return;
        }

        if ($this->c ?? false) {
            session(['coupon' => $this->c]);

            // dd(session('coupon'));
        }

        return redirect(route('checkout'));
    }

    public function pn($state)
    {
        $this->cpn = $state;
    }
    public function carts()
    {
        $this->carts = ModelsCart::where('user_id', Auth::user()->id)->get();
        $this->qty = $this->carts->toArray();

        $this->subtotal = 0;

        foreach ($this->carts as $key => $item) {
            $this->subtotal += $item->qty * $item->product->price;
        }
    }

    public function minus($id)
    {
        $cart = ModelsCart::where('id', $id)->first();
        if ($cart->qty <= $cart->product->moq) {
            $cart->update(['qty' => $cart->product->moq]);
        } else {
            $cart->decrement('qty');
        }
        $this->carts();
    }

    public function plus($id)
    {
        ModelsCart::where('id', $id)->first()->increment('qty');
        $this->carts();
    }

    public function change()
    {
        foreach ($this->qty as $key => $item) {
            $cart = ModelsCart::where('id', $item['id'])->first();
            if ($item['qty'] <= $cart->product->moq) {
                $cart->update(['qty' => $cart->product->moq]);
            } else {
                $cart->update(['qty' => $item['qty']]);
            }
        }
        $this->carts();
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $cart = ModelsCart::where('id', $id)->first();

            $cart->delete();
            DB::commit();
            $this->carts();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }

    public function updatedCoupon()
    {
        $coupon = Coupon::where('code', $this->coupon)->first();

        if ($coupon) {
            if ($coupon->is_active()) {
                $this->c = $coupon;
                $this->message = "Coupon Applied";
            } else {
                $this->c = '';
                $this->message = "Coupon Expired";
            }
        } else {
            $this->c = '';
            $this->message = "Coupon Invalid";
        }
    }

    public function countDiscount()
    {
        if ($this->subtotal > $this->c->minimum) {
            if ($this->c->type == 'fixed') {
                return $this->c->amount;
            } else {
                $discount = 0;
                foreach ($this->carts as $key => $item) {
                    $link = CouponProduct::where('coupon_id', $this->c->id)->where('product_id', $item->product->id)->first();

                    if ($link) {
                        $discount += $this->c->amount / 100 * $item->product->price * $item->qty;
                    }

                }
                if ($this->c->maximum > 0) {
                    $discount = min($discount, $this->c->maximum);
                }
                return $discount;
            }
        }
        return 0;
    }

    public function render()
    {
        return view('livewire.cart')->layout('components.layouts.app.header', ['title' => 'My Cart']);
    }
}
