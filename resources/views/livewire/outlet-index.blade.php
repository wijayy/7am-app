<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>
    <flux:container-sidebar>
        <div class="flex justify-end">
            <flux:button variant="primary" icon="plus" href="{{ route('outlet.create') }}">Add Outlet
            </flux:button>
        </div>
        <div class="flex gap-4 min-w-3xl font-semibold py-2">
            <div class="w-10">#</div>
            <div class="w-1/4 ">Outlet</div>
            <div class="w-1/4 text-center">Address</div>
            <div class="w-1/4 text-center">Section</div>
            <div class="w-1/4 text-center">Action</div>
        </div>

        @foreach ($outlets as $key => $item)
            <div class="flex gap-4 min-w-3xl py-2 items-center">
                <div class="w-10">{{ $key + 1 }}</div>
                <div class="w-1/4 ">{{ $item->name }}</div>
                <div class="w-1/4 ">{{ $item->address }}</div>
                <div class="w-1/4 text-center py-1">
                    @foreach ($item->sections as $itm)
                        <div class="">{{ $itm->name }}</div>
                    @endforeach
                </div>
                <div class="w-1/4 text-center flex justify-center items-center gap-2">
                    <flux:tooltip content="Show Outlet">
                        <flux:button size="sm" icon='eye' variant="primary" color="emerald"
                            href="{{ route('outlet-show', $item->slug) }}"></flux:button>
                    </flux:tooltip>
                    <flux:tooltip content="Edit Outlet">
                        <flux:button size="sm" icon='pencil-square' variant="primary" color="amber"
                            href="{{ route('outlet.edit', $item->slug) }}"></flux:button>
                    </flux:tooltip>
                    <flux:tooltip content="Edit Outlet">
                        <flux:button size="sm" icon='trash' variant="danger"
                            wire:click='$dispatch("openEditModal", {id:{{ $item->id }}})'></flux:button>
                    </flux:tooltip>
                </div>
            </div>
        @endforeach
    </flux:container-sidebar>
    {{-- @livewire('outlet-create') --}}
</div>
