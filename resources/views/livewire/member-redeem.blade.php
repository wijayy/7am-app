<div class="space-y-4">
    <flux:modal name='redeem-point'>
        <div class="mt-4">{{ $code }} {{ $name }} Redeeming Point</div>
        <form wire:submit='redeem' class="grid grid-cols-1 mt-4 gap-4">
            <div class="">
                <flux:select wire:model.live='outlet_id' :disabled="Auth::user()->outlet" label="Outlet">
                    <flux:select.option value="">--Select Outlet--</flux:select.option>
                    @foreach ($outlets as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select wire:model.live='redeem_id' label="Redeem Reward">
                    <flux:select.option value="">--Select Redeem Reward--</flux:select.option>
                    @foreach ($redeems as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:button variant="primary" type="submit">Submit</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
