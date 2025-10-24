<?php

namespace App\Livewire;

use App\Models\Bussiness;
use App\Models\SetCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BusinessIndex extends Component
{
    public $title = "All Registered Business", $business, $setCategory;

    #[Validate('required')]
    public $status = '';

    #[Validate('required_if:status,accepted')]
    public $name = '', $set_category_id;

    public function mount()
    {
        // $this->business = Bussiness::all();
        // $this->request(1, 'rejected');
        $this->setCategory = SetCategory::all();
    }

    public function openDetailModal($id)
    {
        $this->business = Bussiness::find($id);
        $this->dispatch('modal-show', name: 'detail-business');
    }

    public function save()
    {
        $business = $this->business;
        $validated = $this->validate();
        // dd($id);

        try {
            DB::beginTransaction();
            $business->update($validated);
            DB::commit();
            $message = match ($this->status) {
                'accepted' => 'Business berhasil diterima!',
                'rejected' => 'Business ditolak!',
                default => 'Business berhasil diupdate!'
            };
            session()->flash('Success', $message);
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
        return view('livewire.business-index', ['businesses' => Bussiness::paginate(24)])->layout('components.layouts.app', ['title' => $this->title]);
    }
}
