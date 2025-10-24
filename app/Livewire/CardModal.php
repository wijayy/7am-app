<?php

namespace App\Livewire;

use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CardModal extends Component
{

    public $title = "All Cards";

    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'tailwind';

    public $id = null;
    public $old_card = null;
    public $defaultPreview = null;

    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|string')]
    public $usage = '';

    #[Validate('required|string')]
    public $discount_type = '';

    #[Validate('required|integer|min:1|max:100')]
    public $discount = 0;

    public $card; // file upload

    protected $listeners = ['openCreateModal' => 'openCreateModal', 'openEditModal' => 'openEditModal'];

    public function rules()
    {
        return [
            'card' => $this->id ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'name' => 'required|string|max:100',
            'usage' => 'required|string|max:50',
            'discount' => 'required|integer|min:1|max:100',
            'discount_type' => 'required|string|max:50',
        ];
    }

    public function openCreateModal()
    {
        $this->resetForm();
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
        $this->card = null;
        $this->defaultPreview = asset('storage/' . $card->card);

        $this->dispatch('modal-show', name: 'create-card');
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();

            if ($this->card) {
                $validated['card'] = $this->card->store('card', 'public');
            }

            Card::updateOrCreate(['id' => $this->id], $validated);
            DB::commit();

            session()->flash('success', $this->id ? 'Card updated successfully.' : 'Card created successfully.');

            $this->resetForm();
            $this->dispatch('modal-close', name: 'create-card');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', config('app.debug') ? $th->getMessage() : 'Something went wrong.');
        }
    }

    private function resetForm()
    {
        $this->resetValidation();
        $this->reset(['id', 'name', 'usage', 'discount_type', 'discount', 'card', 'defaultPreview']);
    }

    public function render()
    {
        return view('livewire.card-modal')->layout('components.layouts.app', ['title'=>$this->title]);
    }
}
