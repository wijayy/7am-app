<?php

namespace App\Livewire;

use App\Models\Bussiness;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BusinessIndex extends Component
{
    public $title = "All Registered Business";

    public function mount()
    {
        // $this->business = Bussiness::all();
        // $this->request(1, 'rejected');
    }

    public function request($id, $status, $member = null)
    {
        $business = Bussiness::find($id);
        // dd($id);

        try {
            DB::beginTransaction();
            if ($status == 'rejected') {
                $business->user()->update(['business' => 'rejected']);
                $message = "$business->name request rejected";
            } else {
                $business->user()->update(['business' => 'accepted', 'member' => $member]);
                $message = "$business->name accepted as $member customer";
            }
            DB::commit();
            return redirect(route('business.index'))->with('success', $message);
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
        return view('livewire.business-index', ['business' => Bussiness::paginate(24)])->layout('components.layouts.app', ['title' => $this->title]);
    }
}
