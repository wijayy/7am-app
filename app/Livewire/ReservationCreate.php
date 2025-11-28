<?php

namespace App\Livewire;

use App\Models\Outlet;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Uri\QueryString;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReservationCreate extends Component
{
    #[Url(as: 'outlet')]
    public $slug;


    public $title = "Reserve Your Table", $sections;

    #[Validate('required')]
    public $outlet_id = null;
    public $outlets, $outlet;

    #[Validate('required|string|max:255')]
    public $name = '', $section_id;

    #[Validate('required|string|max:15|doesnt_start_with:0', message: ['doesnt_start_with' => 'Phone number must start with a country code'])]
    public $phone = '';

    #[Validate('required|numeric|min:1')]
    public $pax = 1;

    #[Validate('required|date')]
    public $date = '';
    public $minimum_date;

    #[Validate('required')]
    public $time = '';

    #[Validate('nullable|string')]
    public $note = '';

    // protected $queryString = ['outlet', ];

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->phone = Auth::user()->phone;

        $this->outlet = Outlet::where('slug', $this->slug)->first();
        $this->outlet_id = $this->outlet->id ?? null;
        if ($this->outlet_id) {
            $this->sections = Outlet::find($this->outlet_id)->sections;
        }
        $this->outlets = Outlet::all();

        // Jika sudah lewat jam 21:00, minimum_date besok
        if (date('H:i') >= '21:00') {
            $this->minimum_date = date('Y-m-d', strtotime('+1 day'));
        } else {
            $this->minimum_date = date('Y-m-d');
        }
        // dd($this->outlet_id);
    }

    public function updatedOutletId()
    {
        $this->section_id = null;
        $this->outlet = Outlet::find($this->outlet_id) ?? null;
        $this->sections = $this->outlet->sections ?? null;
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();
            // Gabungkan date dan time menjadi satu variabel date (format: Y-m-d H:i)
            $validated['date'] = $this->date . ' ' . $this->time;
            $validated['user_id'] = Auth::user()->id;
            Reservation::create($validated);
            DB::commit();
            return redirect(route('reservation.history'))->with('success', 'Reservation successful! Please arrive on time as we have prepared the best place for you.');
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
        return view('livewire.reservation-create')->layout('components.layouts.app.reservation-header', ['title' => $this->title]);
    }

    public function messages()
    {
        return [
            'phone.doesnt_start_with' => 'Please make sure to use your country code in your phone number.',
        ];
    }
}
