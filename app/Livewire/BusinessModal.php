<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bussiness;
use Illuminate\Support\Facades\DB;

class BusinessModal extends Component
{
    public $title = "All Registered Business", $business, $setCategory;
    public $id = null;
    protected $paginationTheme = 'tailwind';

    #[Validate('required')]
    public $status = '';

    #[Validate('required_if:status,accepted')]
    public $name = '', $set_category_id;

    protected $listeners = [
        'openCreateBusinessModal' => 'openCreateBusinessModal',
        'openEditBusinessModal' => 'openEditBusinessModal'
    ];

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
        ];
    }

    private function resetForm()
    {
        $this->resetValidation();
        $this->reset(['id', 'business', 'setCategory', 'status', 'name', 'set_category_id']);
    }

    // public function openCreateBusinessModal()
    // {
    //     $this->resetForm();
    //     $this->dispatch('modal-show', name: 'business-modal');
    // }

    public function openEditBusinessModal($id)
    {
        $this->resetValidation();
        $this->business = Bussiness::find($id);
        $this->id = $this->business->id;
        $this->name = $this->business->name;
        $this->status = $this->business->status;

        $this->dispatch('modal-show', name: 'business-modal');
    }

    public function save()
    {
        $business = $this->business;
        $validated = $this->validate();

        try {
            DB::beginTransaction();
            $business->update($validated);
            DB::commit();
            $message = match ($this->status) {
                'approved' => 'Business berhasil diterima!',
                'rejected' => 'Business ditolak!',
                default => 'Business berhasil diupdate!'
            };
            session()->flash('Success', $message);

            $this->resetForm();
            $this->dispatch('modal-close', name: 'business-modal');
            $this->redirect(route('business.index'));
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
        return view('livewire.business-modal');
    }
}
