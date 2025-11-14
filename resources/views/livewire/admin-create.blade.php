<div class="space-y-4">
    <flux:modal name="admin-create">
        <div class="text-center font-semibold">{{ $title }}</div>
        <form wire:submit='save' class="mt-4 grid grid-cols-1 gap-4">
            <flux:input wire:model.live='name' label="Name" required></flux:input>
            <flux:input wire:model.live='email' label="Email" required></flux:input>
            <flux:input wire:model.live='phone' label="Phone" only_number required></flux:input>
            <flux:select wire:model.live='role' label="Role" required>
                <flux:select.option value="">--Select Outlet--</flux:select.option>
                @foreach ($roles as $item)
                    <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model.live='role' label="Outlet">
                <flux:select.option value="">--Select Outlet--</flux:select.option>
                @foreach ($outlets as $item)
                    <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input wire:model.live='password' label="Password" required></flux:input>
            <flux:input wire:model.live='password_confirmation' label="Confirm Password" required></flux:input>

            <div class="flex justify-center">
                <flux:button type="submit" variant="primary">Submit</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
