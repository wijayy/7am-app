<?php

namespace App\Livewire;

use App\Models\Outlet;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OutletShow extends Component
{
    public $outlet, $title, $open = 'gallery', $image1 = [],
        $image2 = [],
        $image3 = [],
        $image4 = [], $limit = 2, $maxLimit;

    public function mount($slug)
    {

        try {
            // DB::beginTransaction();
            $this->outlet = Outlet::where('slug', $slug)->firstOrFail();
            $this->title = "Discover {$this->outlet->name}";

            foreach ($this->outlet->images as $index => $image) {
                switch (($index % 4) + 1) {
                    case 1:
                        $this->image1[] = $image;
                        break;
                    case 2:
                        $this->image2[] = $image;
                        break;
                    case 3:
                        $this->image3[] = $image;
                        break;
                    case 4:
                        $this->image4[] = $image;
                        break;
                }
            }

            $this->maxLimit = max([count($this->image1), count($this->image2), count($this->image3), count($this->image4)]);

            // dd($this->image1);
            // DB::commit();
        } catch (\Throwable $th) {
            // DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }

        // dd($this->outlet);
    }

    public function addLimit()
    {
        $this->limit += 2;
    }

    public function render()
    {
        return view('livewire.outlet-show')->layout('components.layouts.app.reservation-header', ['title' => $this->title]);
    }
}
