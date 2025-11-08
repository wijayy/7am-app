<?php

namespace App\Livewire;

use App\Models\MinimumOrder;
use App\Models\Village;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Session;

class MinimumOrderCreate extends Component
{

    public $title = "Edit Minimum Order", $villages = [], $id;

    #[Validate('required')]
    public $village_id = 0;

    #[Validate('required|integer')]
    public $minimum = 0;

    #[On('openEditMinimumOrderModal')]
    public function openEditMinimumOrderModal($id)
    {
        $minimumOrder = MinimumOrder::find($id);

        // dd($minimumOrder);

        if ($minimumOrder) {
            $this->village_id = $minimumOrder->village_id;
            $this->id = $minimumOrder->id;
            $this->minimum = $minimumOrder->minimum;
            $this->dispatch('modal-show', name: 'minimum-order-create');
        } else {
            session()->flash('error', 'Minimum Order not found');
        }
    }

    public function mount()
    {
        $this->villages = Village::all();

        // dd($villages);
    }

    public function save()
    {
        $validated = $this->validate();
        $minimumOrder = MinimumOrder::find($this->id);

        try {
            DB::beginTransaction();
            $minimumOrder->update($validated);
            DB::commit();
            $this->dispatch('modal-close', name: 'minimum-order-create');
            Session::flash('success', 'Minimum Order updated successfully');
            $this->dispatch('update-minimum-order');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            return back()->with('error', '');
        }
    }

    public function render()
    {
        return view('livewire.minimum-order-create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
