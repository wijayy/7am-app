<flux:modal dismissible="false" name="create-member">
    <form wire:submit.prevent='save' class="space-y-4">
        <div class="text-center text-lg font-semibold mt-4">
            {{ $id ? "Edit Membership Type $name" : 'Add New Membership Type' }}
        </div>
        <flux:input wire:model.live='name' label="Membership Type Name" required></flux:input>
        <flux:input wire:model.live='minimum_point' only_number label="Membership Minimum Point" required>
        </flux:input>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Submit</flux:button>
        </div>
    </form>
</flux:modal>
