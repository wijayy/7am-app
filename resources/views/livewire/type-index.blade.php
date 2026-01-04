<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <flux:container-sidebar>
        <div class="flex justify-end">
            <flux:button icon="plus" variant="primary" wire:click="$dispatch('openCreateModal')">
                Add Membership Type
            </flux:button>
        </div>

        <div class="overflow-x-auto mt-4 rounded-lg">
            <div class="w-full mx-auto border border-gray-200 dark:border-gray-800 rounded-lg min-w-2xl overflow-x-auto">
                <div
                    class=" grid grid-cols-5 bg-gray-100 dark:bg-gray-800/60 text-sm font-semibold text-gray-700 dark:text-gray-300 px-4 py-2">
                    <div>#</div>
                    <div>Name</div>
                    <div class="text-center">Minimum Point</div>
                    <div class="text-center">Member Count</div>
                    <div class="text-center">Action</div>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-neutral-700">
                    @forelse ($types as $item)
                        <div
                            class="grid grid-cols-5 items-center hover:bg-gray-50 dark:hover:bg-neutral-700/40 px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            <div class="font-medium">{{ $loop->iteration }}</div>

                            <div class="text-gray-800 dark:text-gray-200">{{ $item->name }}</div>

                            <div class="text-center text-gray-700 dark:text-gray-300">
                                {{ $item->minimum_point }}
                            </div>

                            <div class="text-center text-gray-700 dark:text-gray-300">
                                {{ $item->members_count }}
                            </div>

                            <div class="flex justify-center gap-2 mt-2 md:mt-0">
                                <flux:tooltip content="Edit Membership Type">
                                    <flux:button icon="pencil-square" wire:click='openEditModal({{ $item->id }})'
                                        size="sm" variant="primary" color="amber" />
                                </flux:tooltip>

                                <flux:tooltip content="Delete Membership Type">
                                    <flux:modal.trigger name="delete-{{ $item->id }}">
                                        <flux:button icon="trash" size="sm" variant="danger" />
                                    </flux:modal.trigger>
                                </flux:tooltip>
                            </div>
                        </div>

                        <flux:modal name="delete-{{ $item->id }}">
                            <div class="font-semibold">Delete Membership Type {{ $item->name }}</div>
                            <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                This action will permanently remove membership {{ $item->name }}.
                            </div>
                            <div class="flex mt-4 justify-end gap-2">
                                <flux:button variant="primary"
                                    x-on:click="$dispatch('modal-hide', { name: 'delete-{{ $item->id }}' })">
                                    Cancel
                                </flux:button>
                                <flux:button wire:click='delete({{ $item->id }})' variant="danger">Delete
                                </flux:button>
                            </div>
                        </flux:modal>
                    @empty
                        <div class="py-6 text-center text-gray-500 dark:text-gray-300">
                            No membership types found.
                        </div>
                    @endforelse
                </div>
            </div>


        </div>

        {{-- Modal Create/Edit --}}
        @livewire('type-modal')
        </flux:container->
</div>
