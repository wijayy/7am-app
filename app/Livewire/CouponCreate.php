<?php

namespace App\Livewire;

use App\Models\Coupon;
use App\Models\CouponProduct;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use PHPUnit\Framework\Constraint\Count;

class CouponCreate extends Component
{

    public $coupon, $slug, $title, $products, $selectedProducts, $categories;

    #[Validate('required|string')]
    public $code = '';

    #[Validate('required|integer')]
    public $amount = 0;

    #[Validate('required')]
    public $type = 'fixed';

    #[Validate('required')]
    public $start_date = '';

    #[Validate('required')]
    public $end_date = '';

    #[Validate('required')]
    public $start_time = '';

    #[Validate('required')]
    public $end_time = '';

    #[Validate('required|integer')]
    public $minimum = 0;

    #[Validate('integer|nullable')]
    public $maximum = 0;

    #[Validate('integer')]
    public $limit = 0;

    public function mount($slug = null)
    {
        $coupon = Coupon::where('slug', $slug)->first();

        if ($coupon ?? false) {
            $this->coupon = $coupon->id;
            $this->code = $coupon->code;
            $this->amount = $coupon->amount;
            $this->type = $coupon->type;
            $this->limit = $coupon->limit;
            $this->minimum = $coupon->minimum;
            $this->maximum = $coupon->maximum;
            $this->start_time = $coupon->start_time->format('H:i');
            $this->end_time = $coupon->end_time->format('H:i');
            $this->start_date = $coupon->start_time->format('Y-m-d');
            $this->end_date = $coupon->end_time->format('Y-m-d');
            $this->title = "Edit coupon {$coupon->code}";
        } else {
            $this->title = "Add new coupon";
        }

        $this->categories = Category::with('products')->get();
        $this->products = Product::all();
        $this->selectedProducts = CouponProduct::where('coupon_id', $this->coupon)
            ->pluck('product_id')
            ->toArray();
    }

    public function toggleProduct($productId)
    {
        if (in_array($productId, $this->selectedProducts)) {
            // kalau sudah ada → hapus
            $this->selectedProducts = array_diff($this->selectedProducts, [$productId]);
        } else {
            // kalau belum ada → tambahkan
            $this->selectedProducts[] = $productId;
        }
    }

    public function selectAll()
    {
        if (!empty($this->categories) && $this->categories->count()) {
            $this->selectedProducts = $this->categories->flatMap(function ($cat) {
                return $cat->products->pluck('id');
            })->toArray();
        } else {
            $this->selectedProducts = collect($this->products)->pluck('id')->toArray();
        }
    }

    public function deselectAll()
    {
        $this->selectedProducts = [];
    }

    public function selectCategory($categoryId)
    {
        $category = $this->categories->firstWhere('id', $categoryId);
        if (!$category) return;
        $ids = $category->products->pluck('id')->toArray();
        $allSelected = count(array_intersect($ids, $this->selectedProducts)) === count($ids);
        if ($allSelected) {
            $this->selectedProducts = array_diff($this->selectedProducts, $ids);
        } else {
            $this->selectedProducts = array_unique(array_merge($this->selectedProducts, $ids));
        }
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            // jika coupon_id ada maka update, kalau tidak create
            $coupon = Coupon::updateOrCreate(
                ['id' => $this->coupon],
                [
                    'code' => $this->code,
                    'amount' => $this->amount,
                    'type' => $this->type,
                    'limit' => $this->limit,
                    'minimum' => $this->minimum,
                    'maximum' => $this->maximum,
                    'start_time' => Carbon::parse($this->start_date . ' ' . $this->start_time),
                    'end_time' => Carbon::parse($this->end_date . ' ' . $this->end_time),
                ]
            );

            $coupon->products()->detach(); // hapus semua relasi lama
            $coupon->products()->attach($this->selectedProducts); // tambahkan yang baru

            // dd($coupon);
            DB::commit();

            session()->flash('success', $this->coupon ? 'Coupon updated successfully!' : 'Coupon created successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.coupon-create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
