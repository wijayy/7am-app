<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <flux:container-sidebar>
        <div class="flex gap-4 flex-wrap md:flex-nowrap">
            <div class="flex gap-4 w-full">

                <flux:input wire:model.live='search' placeholder="Search member name/code"></flux:input>
                <div class="">

                    <flux:select wire:model.live='ty'>
                        <flux:select.option value="">--Select Membership Type--</flux:select.option>
                        @foreach ($types as $item)
                            <flux:select.option value="{{ $item->slug }}">{{ $item->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
            <flux:button icon="plus" wire:click='openCreateModal'>
                Register New Member
            </flux:button>
        </div>

        <div class="mt-4 overflow-x-auto">
            <div class="flex gap-4 min-w-4xl py-2">
                <div class="w-10">#</div>
                <div class="w-2/8">Name</div>
                <div class="w-1/8 text-center">Code</div>
                <div class="w-1/8 text-center">Card</div>
                <div class="w-1/8 text-center">Total Point</div>
                <div class="w-1/8 text-center">Active Point</div>
                <div class="w-2/8 text-center">Action</div>
            </div>
            @foreach ($members as $item)
                <div
                    class="flex items-center gap-4 min-w-4xl py-1 border-b last:border-0 border-black dark:border-white text-sm md:text-base">
                    <div class="w-10">{{ $loop->iteration }}</div>
                    <div class="w-2/8 ">{{ $item->name }}</div>
                    <div class="w-1/8 text-center">{{ $item->code }}</div>
                    <div class="w-1/8 text-center">{{ $item->card->name }}</div>
                    <div class="w-1/8 text-center">{{ $item->total_point }}</div>
                    <div class="w-1/8 text-center">{{ $item->active_point }}</div>
                    <div class="w-2/8 flex gap-2 justify-center">
                        <flux:tooltip content="Redeem Point">
                            <flux:button wire:click='openRedeemModal({{ $item->id }})' icon="gift"
                                variant="primary" size="sm" color="emerald"></flux:button>
                        </flux:tooltip>
                        <flux:tooltip content="Input Transaction">
                            <flux:button wire:click='openTransactionModal({{ $item->id }})' icon="book-plus"
                                variant="primary" size="sm" color="indigo"></flux:button>
                        </flux:tooltip>
                        <flux:tooltip content="Show Member">
                            <flux:button href="{{ route('member.show', $item->slug) }}" icon="eye"
                                variant="primary" size="sm"></flux:button>
                        </flux:tooltip>
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
    </flux:container-sidebar>
    @livewire('member-create')
    @livewire('member-redeem')

    @livewire('member-transaction')

</div>
