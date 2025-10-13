<?php

namespace App\Livewire;

use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CardIndex extends Component
{
    use WithFileUploads;

    public $title = "All Cards", $id, $cards, $old_card, $defaultPreview;

    #[Validate('required|string')]
    public $name = '', $usage, $discount_type;

    // #[Validate('nullable|file|image')]


    public $card = '';

    #[Validate('required|integer|min:1|max:100')]
    public $discount = '';

    public function rules()
    {
        return [
            'card' => $this->id ? 'nullable|file|image' : 'required|file|image'
        ];
    }

    public function openCreateModal()
    {
        $this->resetValidation();

        $this->id = null;
        $this->name = '';
        $this->usage = '';
        $this->discount_type = '';
        $this->discount = '';
        $this->card = '';
        $this->defaultPreview = null;

        $this->dispatch('modal-show', name: 'create-card');
    }

    public function openEditModal($id)
    {
        $this->resetValidation();

        $card = $this->getCard($id);

        $this->id = $card->id;
        $this->name = $card->name;
        $this->usage = $card->usage;
        $this->discount_type = $card->discount_type;
        $this->discount = $card->discount;
        $this->card = '';
        $this->defaultPreview = asset('storage/' . $card->card);

        $this->dispatch('modal-show', name: 'create-card');
    }

    public function getCard($id)
    {
        $card = Card::find($id);
        if (!$card) {
            throw new \Exception("Card not found");
        }

        return $card;
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $card = $this->getCard($id);
            $card->delete();
            DB::commit();

            $this->cards = Card::all();

            session()->flash('success', 'Card deleted successfully.');

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

    public function mount()
    {
        $this->cards = Card::all();


        // $this->openEditModal(1);
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            $validated = $this->validate();

            // dd($this->card);
            if ($this->card != '') {
                // save image
                $path = $this->card->store('card');
                $validated['card'] = $path;
            } else {
                unset($validated['card']);
            }

            Card::updateOrCreate(['id' => $this->id], $validated);

            DB::commit();

            // refresh list
            $this->cards = Card::all();
            // success message
            $message = $this->id ? 'Card updated successfully.' : 'Card created successfully.';
            session()->flash('success', $message);

            // reset validations and close modal
            $this->resetValidation();
            $this->dispatch('modal-close', name: 'create-card');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                session()->flash('error', $th->getMessage());
                throw $th;
            } else {
                session()->flash('error', $th->getMessage());
            }
        }
    }
    
    public function render()
    {
        return view('livewire.card-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
