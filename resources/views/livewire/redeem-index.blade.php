<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <flux:container-sidebar>
        <div class="flex gap-4 justify-end">
            <flux:button icon="plus" wire:click='openCreateModal'>
                Register New Member
            </flux:button>
        </div>

        <div class="mt-4 overflow-x-auto">
            <div class="flex gap-4 min-w-4xl py-2">
                <div class="w-10">#</div>
                <div class="w-1/4">Name</div>
                <div class="w-1/4 ">Reward</div>
                <div class="w-1/4 text-center">Redeem Point</div>
                <div class="w-1/4 text-center">Action</div>
            </div>
            @foreach ($redeems as $item)
                <div
                    class="flex items-center gap-4 min-w-4xl py-1 border-b last:border-0 border-black dark:border-white text-sm md:text-base">
                    <div class="w-10">{{ $loop->iteration }}</div>
                    <div class="w-1/4 ">{{ $item->name }}</div>
                    <div class="w-1/4 ">{{ $item->reward }}</div>
                    <div class="w-1/4 text-center">{{ $item->point }}</div>
                    <div class="w-1/4 flex gap-2 justify-center">
                        <flux:tooltip content="Edit Member">
                            <flux:button wire:click='openEditModal({{ $item->id }})' icon="pencil-square"
                                variant="primary" color="amber" size="sm"></flux:button>
                        </flux:tooltip>
                        <flux:tooltip content="Delete Member">
                            <flux:modal.trigger class="trigger" name="delete-{{ $item->id }}">
                                <flux:button icon="trash" variant="primary" color="red" size="sm">
                                </flux:button>
                            </flux:modal.trigger>
                        </flux:tooltip>
                    </div>
                    <flux:modal name="delete-{{ $item->id }}">
                        <div class="font-semibold ">Delete {{ $item->name }}</div>
                        <div class="">This action will permanently remove {{ $item->name }}.</div>
                        <div class="flex mt-4 justify-end">
                            <flux:button wire:click='delete({{ $item->id }})' variant="danger">Delete
                            </flux:button>
                        </div>
                    </flux:modal>
                </div>
            @endforeach
        </div>
        <flux:modal name="create-redeem" class="w-3xl!">
            <div class="mt-4">{{ $id ? "Edit Data Member $name" : 'Register New Member' }}</div>
            <form wire:submit='save' class="grid grid-cols-1 mt-4 gap-4">
                <div class="">
                    <flux:input wire:model.live='name' label="Name" required></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='reward'  label="Reward" required></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='point' type="integer" label="Redeem Point" required></flux:input>
                </div>
                <div class="">
                    <flux:button variant="primary" type="submit">Submit</flux:button>
                </div>
            </form>
        </flux:modal>
    </flux:container-sidebar>
</div>
