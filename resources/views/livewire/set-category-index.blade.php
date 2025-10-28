<div class="space-y-4">
    <flux:container-sidebar>
        <!-- Header -->
        <div class="flex justify-start mb-2">
            <flux:session>{{ $title }}</flux:session>
            <flux:button icon="plus" variant="primary" wire:click="$dispatch('createModal')">
                Add New Set Category
            </flux:button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white dark:bg-neutral-800 rounded-lg">
            <div
                class="grid grid-cols-3 font-semibold text-center text-sm border-b border-gray-300 py-4 text-gray-800 dark:text-white">
                <div>Name</div>
                <div>Slug</div>
                <div>Action</div>
            </div>

            @forelse ($setCategories as $key => $item)
                <div class="grid grid-cols-3 items-center py-2 text-center">
                    <div class="text-center">
                        {{ $item->name }}
                    </div>

                    <div class="text-center">
                        {{ $item->slug }}
                    </div>

                    <div class="text-center flex justify-center items-center gap-2">
                        <flux:tooltip content="Edit Set Category">
                            <flux:button wire:click="$dispatch('editModal', { id: {{ $item->id }} }).global"
                                icon="pencil-square" size="sm" variant="primary" color="amber">
                            </flux:button>
                        </flux:tooltip>

                        <flux:tooltip content="Delete Set Category">
                            <flux:modal.trigger name="delete-{{ $item->id }}">
                                <flux:button icon="trash" size="sm" variant="danger">
                                </flux:button>
                            </flux:modal.trigger>
                        </flux:tooltip>
                    </div>
                </div>
                <!-- Modal Delete -->
                <flux:modal name="delete-{{ $item->id }}">
                    <div class="font-semibold text-lg">Delete {{ $item->name }}</div>
                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        This action will permanently remove <strong>{{ $item->name }}</strong>.
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <flux:button variant="primary"
                            x-on:click="$dispatch('modal-close', { name: 'delete-{{ $item->id }}' })">
                            Cancel
                        </flux:button>
                        <flux:button wire:click='delete({{ $item->id }})' variant="danger">
                            Delete
                        </flux:button>
                    </div>
                </flux:modal>
            @empty
                <div class="flex justify-center items-center w-full h-80 font-semibold text-gray-500">
                    Looks like your cart is lonely. Add products to make it happy!
                </div>
            @endforelse
        </div>

        <!-- Modal Create/Edit -->
        @livewire('set-category-create')
    </flux:container-sidebar>
</div>
