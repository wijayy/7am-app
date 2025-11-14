<flux:modal name="create-card" size="lg">
    <div class="mt-4 text-center text-lg font-semibold">
        {{ $id ? "Edit Card $name" : 'Add New Card' }}
    </div>

    <form wire:submit='save' class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div class="md:col-span-2">
            <flux:input type="file" aspect="16/10" wire:model.live='card' label="Card Image"
                preview='{{ $defaultPreview }}'>
            </flux:input>
        </div>

        <flux:input wire:model.live='name' label="Card Name" required></flux:input>
        <flux:input wire:model.live='usage' label="Usage" required></flux:input>
        <flux:input wire:model.live='discount' label="Discount (%)" required></flux:input>
        <flux:input wire:model.live='discount_type' label="Discount Type" required></flux:input>

        <div class="flex justify-center md:col-span-2 mt-2">
            <flux:button variant="primary" type="submit">Submit</flux:button>
        </div>
    </form>
</flux:modal>
