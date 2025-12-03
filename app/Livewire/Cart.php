<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Address;
use App\Models\Cart as ModelsCart;
use App\Models\Coupon;
use App\Models\Outlet;
use Livewire\Component;
use App\Models\Shipping;
use App\Models\CouponUsage;
use App\Models\Transaction;
use App\Models\CouponProduct;
use App\Models\MinimumOrder;
use App\Models\Payment;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Minimum;
use Session;

class Cart extends Component
{
    public $carts, $qty, $subtotal, $coupon, $cpn = false, $c, $message, $addresses, $address, $outlet, $outlets, $min, $shipping_date, $packaging_fee;
    public $fulfillment = 'delivery';

    public function mount()
    {

        if (Auth::user()->addresses->isEmpty()) {
            return redirect(route('settings.address'))->with('info', 'Please add your address before checkout');
        }


        $this->carts();


        $this->addresses = Auth::user()->addresses ?? collect();

        // dd($this->addresses);
        $this->address = $this->addresses->first();

        if ($this->carts->count() == 0) {
            return redirect(route('home'));
        }

        $this->addresses = Auth::user()->addresses;
        $this->address = $this->addresses->first();

        $this->outlets = Outlet::where('is_active', true)->get();
        $this->outlet = $this->outlets->first();

        $this->setMinShippingDate();
    }

    public function checkout()
    {
        // dd(Auth::user()->bussinesses?->status);


        if (is_null(Auth::user()->bussinesses) || Auth::user()->bussinesses?->status != 'approved') {
            $this->dispatch('error');
            return;
        }

        if ($this->fulfillment === 'delivery') {
            $minimumOrder = MinimumOrder::where('village_id', $this->address->village_id)->first();
            if ($this->subtotal < $minimumOrder->minimum) {
                Session::flash('error', 'Minimum order to ' . $minimumOrder->village->name . ' is Rp. ' . number_format($minimumOrder->minimum, 0, ',', '.'));
                return;
            }
        }

        try {
            DB::beginTransaction();
            $transaction = Transaction::create([
                'subtotal' => $this->subtotal,
                'transaction_number' => Transaction::transactionNumberGenerator(),
                'discount' => $this->countDiscount(),
                'total' => $this->subtotal + $this->packaging_fee - $this->countDiscount(),
                'packaging_fee' => $this->packaging_fee,
                'shipping_date' => $this->shipping_date,
                'due_date' => Carbon::now()->addDays(Auth::user()->bussinesses->tenor)->setTime(19, 0)->toDateTimeString(),
                'user_id' => Auth::user()->id,
                'status' => 'ordered'
            ]);

            if ($this->fulfillment === 'delivery') {
                $shippingData = [
                    'user_id' => Auth::user()->id,
                    'transaction_id' => $transaction->id,
                    'name' => $this->address->name,
                    'type' => $this->fulfillment,
                    'phone' => $this->address->phone,
                    'email' => Auth::user()->email,
                    'address' => $this->address->address,
                ];
            } else {
                $shippingData = [
                    'user_id' => Auth::user()->id,
                    'transaction_id' => $transaction->id,
                    'type' => $this->fulfillment,
                    'name' => Auth::user()->bussinesses->name,
                    'phone' => Auth::user()->phone,
                    'email' => Auth::user()->email,
                    'address' => $this->outlet->address,
                ];
            }

            $shipping = Shipping::create($shippingData);

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

            // $this->carts()->delete();
            ModelsCart::where('user_id', Auth::user()->id)->delete();

            DB::commit();
            Mail::to(Auth::user()->email)->send(new \App\Mail\Order\Order($transaction->slug));
            $this->redirect(route('checkout', ['slug' => $transaction->slug]));
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false))
                throw $th;
            return back()->with('error', '');
        }
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

        $this->packaging_fee = 0.03 * $this->subtotal;
        // dd($this->packaging_fee);
    }

    public function minus($id)
    {
        $cart = ModelsCart::where('id', $id)->first();
        if ($cart->qty <= $cart->product->moq) {
            $cart->update(['qty' => $cart->product->moq]);
            session()->flash('info', "{$cart->product->name} has MOQ on {$cart->product->moq} pcs");
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
                session()->flash('info', "{$cart->product->name} has MOQ on {$cart->product->moq} pcs");
            } else {
                $cart->update(['qty' => $item['qty']]);
            }
        }
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
        if (!$this->c ?? false) {
            return 0;
        }
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

        $min = 1;

        if (!$now->lt($now->copy()->setTime(17, 0))) {
            // sebelum jam 5 sore → minimal besok
            $min++;
        }

        // Jika ada produk sourdough di cart, min++
        foreach ($this->carts as $item) {
            if (stripos($item->product->name, 'sourdough') !== false) {
                $min++;
                break;
            }
        }

        $this->min = $now->copy()->addDays($min)->toDateString();
        $this->shipping_date = $this->min;
    }

    public function openShowModal($jurnal_id)
    {
        $this->dispatch('showModal', jurnal_id: $jurnal_id);
    }

    public function changeOutlet($id)
    {
        $this->outlet = Outlet::find($id);
        $this->dispatch('modal-close', name: 'outlet');
    }

    public function changeAddress($id)
    {
        $this->address = Address::find($id);

        $this->dispatch('modal-close', name: 'address');
    }

    public function render()
    {
        // Pada render halaman cart.blade.php, buatin untuk kirim data list dari outlet yang ada juga
        // Dan method buat change nya juga
        return view('livewire.cart')->layout('components.layouts.app.header', ['title' => 'My Cart']);
    }
}
