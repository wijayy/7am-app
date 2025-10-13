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
        <flux:modal name="create-member" class="w-3xl!">
            <div class="mt-4">{{ $id ? "Edit Data Member $name" : 'Register New Member' }}</div>
            <form wire:submit='save' class="grid grid-cols-1 mt-4 md:grid-cols-2 gap-4">
                <div class="">
                    <flux:input wire:model.live='name' label="Member Name" required></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='code' only_number label="Code on Card" required></flux:input>
                </div>
                <div class="">
                    <flux:select wire:model.live='type_id' label="Membership Type">
                        <flux:select.option value="">--Select Membership Type--</flux:select.option>
                        @foreach ($types as $item)
                            <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="">
                    <flux:input wire:model.live='point' only_number label="Point" :readonly="$id || $input_point">
                    </flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='phone' only_number label="Phone Number" required></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='email' label="Email" required></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='birthday' type="date" label="Birthday" required></flux:input>
                </div>
                <div class=""></div>
                <div class="">
                    <flux:button variant="primary" type="submit">Submit</flux:button>
                </div>
            </form>
        </flux:modal>

        <flux:modal name='redeem-point'>
            <div class="mt-4">{{ $code }} {{ $name }} Redeeming Point</div>
            <form wire:submit='redeem' class="grid grid-cols-1 mt-4 gap-4">
                <div class="">
                    <flux:select wire:model.live='outlet_id' :disabled="Auth::user()->outlet" label="Outlet">
                        <flux:select.option value="">--Select Outlet--</flux:select.option>
                        @foreach ($outlets as $item)
                            <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select wire:model.live='redeem_id' label="Redeem Reward">
                        <flux:select.option value="">--Select Redeem Reward--</flux:select.option>
                        @foreach ($redeems as $item)
                            <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="">
                    <flux:button variant="primary" type="submit">Submit</flux:button>
                </div>
            </form>
        </flux:modal>
        <flux:modal name='transaction'>
            <div class="mt-4">{{ $code }} {{ $name }} Input Transaction</div>
            <form wire:submit='inputTransaction' class="grid grid-cols-1 mt-4 gap-4">
                <div class="">
                    <flux:select wire:model.live='outlet_id' :disabled="Auth::user()->outlet" label="Redeem Reward">
                        <flux:select.option value="">--Select Outlet--</flux:select.option>
                        @foreach ($outlets as $item)
                            <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="">
                    <flux:input wire:model.live='amount' type="number" label="Transaction Amount" required></flux:input>
                </div>
                <div class="">
                    <flux:input wire:model.live='poin' label="Point Gained" readonly></flux:input>
                </div>
                <div class="">
                    <flux:button variant="primary" type="submit">Submit</flux:button>
                </div>
            </form>
        </flux:modal>
    </flux:container-sidebar>
</div>
