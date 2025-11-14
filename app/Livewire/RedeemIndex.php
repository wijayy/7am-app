<?php

namespace App\Livewire;

use App\Models\RedeemPoint;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RedeemIndex extends Component
{
    public $title = "Redeem Reward", $redeems, $id;

    #[Validate('required|string')]
    public $name = '', $reward = '';

    #[Validate('required|numeric')]
    public $point = '';

    public function getRedeem()
    {
        $this->redeems = RedeemPoint::orderBy('point')->get();
    }

    public function openCreateModal()
    {
        $this->resetValidation();

        $this->id = null;
        $this->name = '';
        $this->reward = '';
        $this->point = 0;

        $this->dispatch('modal-show', name: 'create-redeem');
    }

    public function openEditModal($id)
    {
        $this->resetValidation();
        $redeem = RedeemPoint::find($id);
        if (!$redeem) {
            session()->flash('error', 'Redeem reward not found.');
            return;
        }

        $this->id = $redeem->id;
        $this->name = $redeem->name;
        $this->reward = $redeem->reward;
        $this->point = $redeem->point;

        $this->dispatch('modal-show', name: 'create-redeem');
    }


    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $redeem = RedeemPoint::find($id);
            if (!$redeem) {
                session()->flash('error', 'Member not found.');
                return;
            }

            $redeem->delete();

            DB::commit();

            // refresh list
            $this->getRedeem();

            session()->flash('success', 'Redeem reward deleted successfully.');

            // optional: notify frontend to close any delete confirmation
            $this->dispatch('modal-close', name: "delete-$id");
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            $validated = $this->validate();

            RedeemPoint::updateOrCreate(['id' => $this->id], $validated);

            DB::commit();

            // refresh list
            $this->getRedeem();

            // success message
            $message = $this->id ? 'Redeem reward updated successfully.' : 'Redeem reward created successfully.';
            session()->flash('success', $message);

            // reset validations and close modal
            $this->resetValidation();
            $this->dispatch('modal-close', name: 'create-redeem');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }

    public function mount()
    {
        $this->getRedeem();
    }

    public function render()
    {
        return view('livewire.redeem-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
