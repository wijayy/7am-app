<?php

namespace App\Livewire;

use App\Models\Newsletter as ModelsNewsletter;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Newsletter extends Component
{
    #[Validate('email|unique:newsletters,email')]
    public $email = '';

    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();
            ModelsNewsletter::create($validated);
            DB::commit();
            session()->flash('newsletter', "Your email recorded, please check your email regularly to see our promo!");
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }

    public function mount() {}
}
