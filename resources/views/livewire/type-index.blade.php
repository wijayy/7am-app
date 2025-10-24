<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <div class="p-4 bg-white dark:bg-neutral-800 shadow rounded space-y-4">
        <div class="flex justify-end">
            <flux:button icon="plus" variant="primary" wire:click='openCreateModal'>
                Add Membership Type
            </flux:button>
        </div>

        <div class="overflow-x-auto rounded-lg">
            <table
                class="w-1/2 border border-gray-200 mx-auto dark:border-neutral-700 divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-100 dark:bg-neutral-700/60">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">#</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Name</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">Minimum
                            Point</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">Member
                            Count</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-300">Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-neutral-700">
                    @forelse ($types as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/40">
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $item->name }}</td>
                            <td class="px-4 py-2 text-center text-sm text-gray-700 dark:text-gray-300">
                                {{ $item->minimum_point }}</td>
                            <td class="px-4 py-2 text-center text-sm text-gray-700 dark:text-gray-300">
                                {{ $item->members_count }}</td>
                            <td class="px-4 py-2 flex justify-center gap-2">
                                <flux:tooltip content="Edit Membership Type">
                                    <flux:button icon="pencil-square" wire:click='openEditModal({{ $item->id }})'
                                        size="sm" variant="primary" color="amber"></flux:button>
                                </flux:tooltip>

                                <flux:tooltip content="Delete Membership Type">
                                    <flux:modal.trigger name="delete-{{ $item->id }}">
                                        <flux:button icon="trash" size="sm" variant="danger"></flux:button>
                                    </flux:modal.trigger>
                                </flux:tooltip>
                            </td>
                        </tr>

                        <flux:modal name="delete-{{ $item->id }}">
                            <div class="font-semibold">Delete Membership Type {{ $item->name }}</div>
                            <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                This action will permanently remove membership {{ $item->name }}.
                            </div>
                            <div class="flex mt-4 justify-end gap-2">
                                <flux:button variant="primary"
                                    x-on:click="$dispatch('modal-close', { name: 'delete-{{ $item->id }}' })">
                                    Cancel
                                </flux:button>
                                <flux:button wire:click='delete({{ $item->id }})' variant="danger">Delete
                                </flux:button>
                            </div>
                        </flux:modal>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-300">
                                No membership types found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-2 w-1/2 mx-auto">
            {{ $types->links() }}
        </div>

        {{-- Modal Create/Edit --}}
        <flux:modal dismissible="false" name="create-member">
            <form wire:submit='save' class="space-y-4">
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
    </div>
</div>
