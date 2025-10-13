<?php

namespace App\Livewire;

use App\Models\Address as ModelsAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Address extends Component
{
    public $addressess, $id;

    #[Validate('required')]
    public $name = '';

    #[Validate('required|doesnt_start_with:0')]
    public $phone = '';

    #[Validate('required')]
    public $address = '';

    public function mount()
    {
        $this->addressess = Auth::user()->addresses;
    }

    public function openCreateModal()
    {
        // kirim event ke frontend
        $this->id = null;
        $this->name = null;
        $this->phone = null;
        $this->address = null;
        $this->dispatch('modal-show', name: 'create-address');
        // dd(true);
    }

    public function openEditModal($id)
    {
        $address = ModelsAddress::find($id);
        $this->id = $address->id;
        $this->name = $address->name;
        $this->phone = $address->phone;
        $this->address = $address->address;

        $this->dispatch('modal-show', name: 'create-address');
    }

    public function save()
    {
        $validated = $this->validate();
        $validated['user_id'] = Auth::user()->id;

        try {
            DB::beginTransaction();
            ModelsAddress::updateOrCreate(['id' => $this->id], $validated);
            DB::commit();

            $this->addressess = Auth::user()->addresses;

            $this->dispatch('modal-close', name: 'create-address');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.address')->layout('components.layouts.app.header', ['title' => "My Address"]);
    }
}
