<div class="space-y-4">

    <flux:container-sidebar>
        <!-- Header -->
        <div class="flex justify-start mb-2">
            <flux:session>{{ $title }}</flux:session>
            <flux:button icon="plus" variant="primary" wire:click="$dispatch('openCreateModal')">
                Add Card
            </flux:button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white dark:bg-neutral-800 rounded-lg">
            <table
                class="w-full mx-auto divide-y divide-gray-200 dark:divide-neutral-700 border border-gray-200 dark:border-neutral-700">
                <thead class="bg-gray-100 dark:bg-neutral-700/60">
                    <tr>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-300 w-12">#
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Card</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">Usage
                        </th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Discount</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Discount Type</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">Action
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-neutral-700">
                    @forelse ($cards as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/40 transition">
                            <td class="px-4 py-2 text-center text-sm text-gray-700 dark:text-gray-300">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-20 h-14 bg-center bg-cover bg-no-repeat rounded-md border border-gray-200 dark:border-neutral-600"
                                        style="background-image: url('{{ asset("storage/$item->card") }}')">
                                    </div>
                                    <span class="font-medium">{{ $item->name }}</span>
                                </div>
                            </td>

                            <td class="px-4 py-2 text-center text-sm text-gray-700 dark:text-gray-300">
                                {{ $item->usage }}
                            </td>

                            <td class="px-4 py-2 text-center text-sm text-gray-700 dark:text-gray-300">
                                {{ $item->discount }}%
                            </td>

                            <td class="px-4 py-2 text-center text-sm text-gray-700 dark:text-gray-300 capitalize">
                                {{ $item->discount_type }}
                            </td>

                            <td class="px-4 py-2 text-center flex justify-center items-center gap-2">
                                <flux:tooltip content="Edit Card">
                                    <flux:button 
                                        wire:click="$dispatch('openEditModal', { id: {{ $item->id }} }).global"
                                        icon="pencil-square"
                                        size="sm" 
                                        variant="primary" 
                                        color="amber">
                                    </flux:button>
                                </flux:tooltip>

                                <flux:tooltip content="Delete Card">
                                    <flux:modal.trigger name="delete-{{ $item->id }}">
                                        <flux:button icon="trash" size="sm" variant="danger">
                                        </flux:button>
                                    </flux:modal.trigger>
                                </flux:tooltip>
                            </td>
                        </tr>

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
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500 dark:text-gray-300">
                                No cards available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="w-full mx-auto mt-6">
            {{ $cards->links() }}
        </div>

        <!-- Modal Create/Edit -->
        @livewire('card-modal')
    </flux:container-sidebar>
</div>
