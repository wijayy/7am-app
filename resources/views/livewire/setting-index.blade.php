<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>
    <flux:container-sidebar>
        <form wire:submit='save'>
            <div class="grid grid-cols-1 gap-4 mt-4">
                <flux:select wire:model.live='default_set_category' :label="'Default Set Category'">
                    <flux:select.option value="0">Select Category</flux:select.option>
                    @foreach ($set_categories as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                {{-- @dd($state) --}}
                @foreach ($state['settings'] as $key => $item)
                    <flux:input wire:model.live="state.settings.{{ $key }}.value" label="{{ $item['key'] }}"
                        type="{{ $item['type'] }}" required />
                @endforeach
            </div>

            <div class="flex justify-center mt-4">
                <flux:button type="submit" variant="primary">Submit</flux:button>
            </div>
        </form>
    </flux:container-sidebar>
</div>
