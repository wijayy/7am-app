<div class="space-y-4">
    <flux:modal name='minimum-order-create'>
        <div class="mt-4">{{ $title }}</div>
        <form wire:submit='save' class="">

            <div class="grid grid-cols-1 gap-4 mt-4">
                <flux:select wire:model.live='village_id' :label="'Village'" disabled>
                    <flux:select.option value="0">Select Village</flux:select.option>
                    @foreach ($villages as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input wire:model.live='minimum' :label="'Minimum Order'" type="number" min="0">
                </flux:input>
            </div>

            <div class="flex justify-center mt-4">
                <flux:button type="submit" variant="primary">Submit</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
