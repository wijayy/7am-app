<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>
    <div class="p-4 bg-white dark:bg-neutral-700 space-y-4">
        <div class="flex justify-end">
            <flux:button icon="plus" variant="primary" wire:click='openCreateModal'>Add Membership Type</flux:button>
        </div>
        <div class="overflow-x-auto">

            <div class="flex gap-4 py-2 min-w-2xl">
                <div class="w-10">#</div>
                <div class="w-1/4">Name</div>
                <div class="w-1/4 text-center">Minimum Point</div>
                <div class="w-1/4 text-center">Member Count</div>
                <div class="w-1/4 text-center">Action</div>
            </div>
            @foreach ($types as $item)
                <div class="flex gap-4 py-1 min-w-2xl">
                    <div class="w-10">{{ $loop->iteration }}</div>
                    <div class="w-1/4 ">{{ $item->name }}</div>
                    <div class="w-1/4 text-center">{{ $item->minimum_point }}</div>
                    <div class="w-1/4 text-center">{{ $item->members->count() }}</div>
                    <div class="flex w-1/4 gap-2 justify-center">
                        <flux:tooltip content="Edit Membership Type">
                            <flux:button icon="pencil-square" wire:click='openEditModal({{ $item->id }})'
                                size="sm" variant="primary" color="amber"></flux:button>
                        </flux:tooltip>
                        <flux:tooltip content="Edit Membership Type">
                            <flux:modal.trigger name="delete-{{ $item->id }}">
                                <flux:button icon="trash" size="sm" variant="danger">
                                </flux:button>
                            </flux:modal.trigger>
                        </flux:tooltip>
                    </div>
                </div>
                <flux:modal name="delete-{{ $item->id }}">
                    <div class="font-semibold ">Delete Membership Type {{ $item->name }}</div>
                    <div class="">This action will permanently remove membership {{ $item->name }}.</div>
                    <div class="flex mt-4 justify-end">
                        <flux:button wire:click='delete({{ $item->id }})' variant="danger">Delete
                        </flux:button>
                    </div>
                </flux:modal>
            @endforeach
        </div>

        <flux:modal dismissible="false" name="create-member">
            <form wire:submit='save' class="space-y-4">
                <div class="text-center min-w-96 w-full mt-4">
                    {{ $id ? "Edit Membership Type $name" : 'Add New Membership Type' }}</div>
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
