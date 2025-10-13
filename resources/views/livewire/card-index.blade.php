<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <flux:container-sidebar>
        <div class="flex justify-end">
            <flux:button wire:click='openCreateModal' icon="plus">Add Cards</flux:button>
        </div>
        <div class="">

            <div class="flex min-w-4xl gap-4 mt-4 py-2 font-semibold">
                <div class="w-10 text-center">#</div>
                <div class="w-2/6">Card</div>
                <div class="w-1/6 text-center">Usage</div>
                <div class="w-1/6 text-center">Discount</div>
                <div class="w-1/6 text-center">Discount_type</div>
                <div class="w-1/6 text-center">Action</div>
            </div>

            @foreach ($cards as $item)
                <div class="flex min-w-4xl items-center gap-4 py-1">
                    <div class="w-10 text-center">{{ $loop->iteration }}</div>
                    <div class="w-2/6 flex items-center gap-2">
                        <div class="w-24 md:w-32 aspect-16/10 bg-center bg-no-repeat bg-cover"
                            style="background-image: url({{ asset("storage/$item->card") }})"></div>
                        <div class="">{{ $item->name }}</div>
                    </div>
                    <div class="w-1/6 text-center">{{ $item->usage }}</div>
                    <div class="w-1/6 text-center">{{ $item->discount }}%</div>
                    <div class="w-1/6 text-center">{{ $item->discount_type }}</div>
                    <div class="w-1/6 text-center flex gap-2 justify-center">
                        <flux:tooltip content="Edit Card">
                            <flux:button wire:click='openEditModal({{ $item->id }})' icon="pencil-square"
                                size="sm" variant="primary" color="amber"></flux:button>
                        </flux:tooltip>
                        <flux:modal.trigger name="delete-{{ $item->id }}">
                            <flux:tooltip content="Delete Card">
                                <flux:button icon="trash" size="sm" variant="primary" color="red">
                                </flux:button>
                            </flux:tooltip>
                        </flux:modal.trigger>
                        <flux:modal name="delete-{{ $item->id }}">
                            <div class="font-semibold ">Delete {{ $item->name }}</div>
                            <div class="">This action will permanently remove {{ $item->name }}.</div>
                            <div class="flex mt-4 justify-end">
                                <flux:button wire:click='delete({{ $item->id }})' variant="danger">Delete
                                </flux:button>
                            </div>
                        </flux:modal>
                    </div>
                </div>
            @endforeach
        </div>

        <flux:modal name='create-card'>
            <div class="mt-4">Add New Card</div>
            <form wire:submit='save' class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                <div class="md:col-span-2">
                    <flux:input type="file" aspect="16/10" wire:model.live='card' label="Card Image"
                        preview='{{ $old_card }}'></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='name' label="Card Name" required></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='usage' label="Usage" required></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='discount' label="Discount" required></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='discount_type' label="Discount Type" required></flux:input>
                </div>
                <div class="flex justify-center md:col-span-2">
                    <flux:button variant="primary" type="submit">Submit</flux:button>
                </div>
        </flux:modal>

    </flux:container-sidebar>
</div>
