<div class="space-y-4">
    <flux:modal name='transaction'>
        <div class="mt-4">{{ $code }} {{ $name }} Input Transaction</div>
        <form wire:submit='inputTransaction' class="grid grid-cols-1 mt-4 gap-4">
            <div class="">
                <flux:select wire:model.live='outlet_id' :disabled="Auth::user()->outlet" label="Redeem Reward">
                    <flux:select.option value="">--Select Outlet--</flux:select.option>
                    @foreach ($outlets as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:input wire:model.live='amount' type="number" label="Transaction Amount" required>
                </flux:input>
            </div>
            <div class="">
                <flux:input wire:model.live='poin' label="Point Gained" readonly></flux:input>
            </div>
            <div class="">
                <flux:button variant="primary" type="submit">Submit</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
