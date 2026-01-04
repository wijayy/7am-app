<div class="space-y-4">
    <flux:session>Categories</flux:session>

    <flux:container-sidebar>
        <div class="flex justify-end">
            <flux:button wire:click='sync' icon='refresh-cw' variant='primary' size='sm'>Sync</flux:button>
        </div>
        <div class="grid grid-cols-12 min-w-lg font-semibold py-2 gap-4">
            <div class="">#</div>
            <div class="col-span-6">Category Name</div>
            <div class="text-center">Status</div>
            <div class="text-center col-span-4">Action</div>
        </div>
        @foreach ($categories as $key => $item)
            <div class="grid grid-cols-12 min-w-lg py-1 gap-4">
                <div class="">{{ $key + 1 }}</div>
                <div class="col-span-6">{{ $item->name }}</div>
                <div class="text-center">
                    <span
                        class="px-2 py-1 text-xs rounded-full {{ $item->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $item->active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="flex gap-2 justify-center col-span-4">
                    @if ($item->active)
                        <flux:button wire:click='toggleStatus({{ $item->id }})' icon='' variant='primary'
                            color="red" size='sm'>Deactivate</flux:button>
                    @else
                        <flux:button wire:click='toggleStatus({{ $item->id }})' icon='' variant='primary'
                            color="green" size='sm'>Activate</flux:button>
                    @endif
                </div>
            </div>
        @endforeach
    </flux:container-sidebar>
</div>
