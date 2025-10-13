<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <flux:container-sidebar>
        <div class="space-y-2">
            <div class="flex gap-4 py-2">
                <div class="w-10">#</div>
                <div class="w-1/5">Business Name</div>
                <div class="w-1/5 text-center">Entity</div>
                <div class="w-1/5 text-center">Registered Number</div>
                <div class="w-1/5 text-center">Status</div>
                <div class="w-1/5 text-center">Action</div>
            </div>
            @foreach ($business as $item)
                <div class="flex gap-4">
                    <div class="w-10">{{ $loop->iteration }}</div>
                    <div class="w-1/5">{{ $item->name }}</div>
                    <div class="w-1/5 text-center">{{ $item->entity }}</div>
                    <div class="w-1/5 text-center">{{ $item->number }}</div>
                    <div class="w-1/5 text-center">{{ $item->user->business == 'accepted' ? "Accepted as {$item->user->member} customer" : $item->user->business }}</div>
                    <div class="w-1/5 text-center">
                        <flux:tooltip content="See Details">
                            <flux:modal.trigger name="business-{{ $item->id }}">
                                <flux:button variant="primary" icon="eye" size="sm"></flux:button>
                            </flux:modal.trigger>
                        </flux:tooltip>
                        <flux:modal name="business-{{ $item->id }}">
                            <div class="mt-4 space-y-4 md:min-w-lg">
                                <div class="">
                                    Detail of Business
                                </div>
                                <flux:separator text="Account Info"></flux:separator>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Email</div>
                                    <div class="w-2/3">: {{ $item->user->email }}</div>
                                </div>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Status</div>
                                    @if ($item->user->business != 'accepted')
                                    <div class="w-2/3">: {{ $item->user->business }}</div>
                                    @else
                                    <div class="w-2/3 text-green-500">: {{ $item->user->business }} as {{ $item->user->member }} customer</div>
                                    @endif
                                </div>
                                <flux:separator text="Business Info"></flux:separator>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Business Name</div>
                                    <div class="w-2/3">: {{ $item->name }}</div>
                                </div>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Business Entity</div>
                                    <div class="w-2/3">: {{ $item->entity }}</div>
                                </div>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Registered Number</div>
                                    <div class="w-2/3">: {{ $item->number }}</div>
                                </div>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Registered Address</div>
                                    <div class="w-2/3">: {{ $item->address }}</div>
                                </div>
                                <flux:separator text="Representative"></flux:separator>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Representative</div>
                                    <div class="w-2/3">: {{ $item->representative }}</div>
                                </div>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Job Title/Position</div>
                                    <div class="w-2/3">: {{ $item->position }}</div>
                                </div>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Phone Number</div>
                                    <a target="_blank" href="https://wa.me/{{ $item->phone }}" class="w-2/3">: {{ $item->phone }}</a>
                                </div>
                                <div class="flex gap-4 text-start">
                                    <div class="w-1/3">Email</div>
                                    <div class="w-2/3">: {{ $item->email }}</div>
                                </div>
                                <div class="flex justify-center flex-wrap gap-4">
                                    @if ($item->user->business == 'requested')
                                        <flux:button wire:click="request({{ $item->id }}, 'rejected')"
                                            variant="danger">Reject</flux:button>
                                        <flux:button wire:click="request({{ $item->id }}, 'accept', 'new')"
                                            variant="primary">Accept as New Customer</flux:button>
                                        <flux:button wire:click="request({{ $item->id }}, 'accept', 'old')"
                                            variant="primary">Accept as Old Customer</flux:button>
                                    @endif
                                    @if ($item->user->member == 'old')
                                        <flux:button wire:click="request({{ $item->id }}, 'accept', 'new')"
                                            variant="primary">Change to New Customer</flux:button>
                                    @endif

                                    @if ($item->user->member == 'new')
                                        <flux:button wire:click="request({{ $item->id }}, 'accept', 'old')"
                                            variant="primary">Change to Old Customer</flux:button>
                                    @endif
                                </div>
                            </div>
                        </flux:modal>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $business->links() }}
        </div>
    </flux:container-sidebar>
</div>
