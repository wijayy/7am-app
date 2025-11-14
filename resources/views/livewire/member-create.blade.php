<div>
    <flux:modal name="create-member" class="w-3xl!">
        <div class="mt-4">{{ $id ? "Edit Data Member $name" : 'Register New Member' }}</div>
        <form wire:submit='save' class="grid grid-cols-1 mt-4 md:grid-cols-2 gap-4">
            <div class="">
                <flux:input wire:model.live='name' label="Member Name" required></flux:input>
            </div>
            <div class="">
                <flux:input wire:model.live='code' only_number label="Code on Card" required></flux:input>
            </div>
            <div class="">
                <flux:select wire:model.live='type_id' label="Membership Type">
                    <flux:select.option value="">--Select Membership Type--</flux:select.option>
                    @foreach ($types as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:select wire:model.live='card_id' label="Membership Type">
                    <flux:select.option value="">--Select Carde--</flux:select.option>
                    @foreach ($cards as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="">
                <flux:input wire:model.live='point' only_number label="Point" :readonly="$id || $input_point">
                </flux:input>
            </div>
            <div class="">
                <flux:input wire:model.live='phone' only_number label="Phone Number" required></flux:input>
            </div>
            <div class="">
                <flux:input wire:model.live='email' label="Email" required></flux:input>
            </div>
            <div class="">
                <flux:input wire:model.live='birthday' type="date" label="Birthday" required></flux:input>
            </div>
            <div class=""></div>
            <div class="">
                <flux:button variant="primary" type="submit">Submit</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
