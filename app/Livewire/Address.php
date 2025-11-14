<?php

namespace App\Livewire;

use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Address as ModelsAddress;

class Address extends Component
{
    public $addressess, $id, $regencies = [], $districts = [], $villages = [];

    #[Validate('required')]
    public $name = '';

    #[Validate('required|doesnt_start_with:0')]
    public $phone = '';

    #[Validate('required')]
    public $address = '', $regency, $district, $village;

    public function mount()
    {
        $this->addressess = Auth::user()->addresses;
        $this->regencies = Regency::all();

        if ($this->regency) {
            $this->districts = District::where('regency_id', $this->regency)->get();
        }
        if ($this->district) {
            $this->villages = Village::where('district_id', $this->district)->get();
        }
    }

    public function updatedRegency($value)
    {
        // dd('adfsdfds');
        $districts = District::where('regency_id', $value)->get();
        $this->districts = $districts;
        // reset downstream selections
        $this->district = null;
        $this->villages = [];
        $this->village = null;
    }

    public function updatedDistrict($value)
    {
        $villages = Village::where('district_id', $value)->get();
        $this->villages = $villages;
        // reset selected village when district changes
        $this->village = null;
    }

    public function openCreateModal()
    {
        // kirim event ke frontend
        $this->id = null;
        $this->name = null;
        $this->phone = null;
        $this->address = null;
        $this->regency = null;
        $this->district = null;
        $this->village = null;

        $this->dispatch('modal-show', name: 'create-address');
        // dd(true);
    }

    public function openEditModal($id)
    {
        $address = ModelsAddress::find($id);

        // dd($address);
        $this->id = $address->id;
        $this->name = $address->name;
        $this->phone = $address->phone;
        $this->address = $address->address;
        // populate options first, then set selected values in order
        $this->regency = $address->regency_id;
        $this->district = $address->district_id;
        $this->village = $address->village_id;

        $this->regencies = Regency::all();
        // set regency and load districts
        $this->districts = District::where('regency_id', $this->regency)->get();

        // set district and load villages
        $this->villages = Village::where('district_id', $this->district)->get();

        // finally set village

        // 🔥 Penting: paksa re-render supaya Livewire sync ulang value <select>
        $this->dispatch('$refresh');

        // sleep(1);

        // dd($this->regency, $this->district, $this->village);

        $this->dispatch('modal-show', name: 'create-address');
    }

    public function save()
    {
        $validated = $this->validate();
        if (!$this->id ?? false) {
            $validated['user_id'] = Auth::user()->id;
        }
        $validated['regency_id'] = $this->regency;
        $validated['district_id'] = $this->district;
        $validated['village_id'] = $this->village;

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
