<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Address;
use App\Models\Cart as ModelsCart;
use App\Models\Coupon;
use App\Models\Outlet;
use App\Models\Address;
use Livewire\Component;
use App\Models\Shipping;
use App\Models\CouponUsage;
use App\Models\Transaction;
use App\Models\CouponProduct;
use App\Models\TransactionItem;
use App\Models\Cart as ModelsCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public $carts, $qty, $subtotal, $coupon, $cpn = false, $c, $message, $addresses, $address, $outlet, $outlets, $min, $shipping_date;
    public $fulfillment = 'delivery';

    public function mount()
    {
        $this->carts();
        $this->addresses = Auth::user()->addresses;
        $this->address = $this->addresses->first();

        if ($this->carts->count() == 0) {
            return redirect(route('home'));
        }

        $this->addresses = Auth::user()->addresses;
        $this->address = $this->addresses->first();
        $this->outlets = Outlet::all();
        $this->outlet = $this->outlets->first();

        $this->setMinShippingDate();
    }

    public function checkout()
    {
        sleep(2);

        if ($this->carts->count() == 0) {
            return;
        }

        try {
            DB::beginTransaction();
            $transaction = Transaction::create([
                'subtotal' => $this->subtotal,
                'number' => Transaction::transactionNumberGenerator(),
                'discount' => $this->discount,
                'total' => $this->total,
                'shipping_date' => $this->shipping_date,
                'user_id' => Auth::user()->id,
                'status' => 'ordered'
            ]);

            $shipping = Shipping::create([
                'user_id' => Auth::user()->id,
                'transaction_id' => $transaction->id,
                'name' => $this->address->name,
                'phone' => $this->address->phone,
                'email' => Auth::user()->email,
                'address' => $this->address->address,
            ]);

            foreach ($this->carts as $key => $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->price,
                    'subtotal' => $item->qty * $item->product->price
                ]);
            }

            if ($this->coupon ?? false) {
                CouponUsage::create(['coupon_id' => $this->coupon->id, 'transaction_id' => $transaction->id]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            return back()->with('error', '');
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
        $this->dispatch('modal-close', name: 'address');
    }

    public function changeOutlet($id)
    {
        $this->outlet = Outlet::find($id);
        $this->dispatch('modal-close', name: 'outlet');
    }

    public function render()
    {
        // Pada render halaman cart.blade.php, buatin untuk kirim data list dari outlet yang ada juga
        // Dan method buat change nya juga
        return view('livewire.cart')->layout('components.layouts.app.header', ['title' => 'My Cart']);
    }
}
