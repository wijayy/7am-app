<?php

namespace App\Livewire;

use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CardIndex extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'tailwind';

    public $title = "All Cards";

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
    public $search = '';

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

    public function updatingSearch()
    {
        $this->resetPage(); // Reset ke page 1 setiap kali search berubah
    }

    public function render()
    {
        $cards = Card::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.card-index', compact('cards'))
            ->layout('components.layouts.app', [
                'title' => $this->title,
            ]);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $card = $this->getCard($id);
            $card->delete();
            DB::commit();

            session()->flash('success', 'Card deleted successfully.');
            $this->dispatch('modal-close', name: "delete-$id");
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', config('app.debug') ? $th->getMessage() : 'Failed to delete card.');
        }
    }

    private function getCard($id)
    {
        $card = Card::find($id);
        if (!$card) {
            throw new \Exception("Card not found");
        }
        return $card;
    }
}
