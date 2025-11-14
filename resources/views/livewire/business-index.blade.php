<div class="space-y-4">
    <div class="flex justify-start space-x-2">
        <flux:session>{{ $title }}</flux:session>
        {{-- <flux:button icon="plus" variant="primary" wire:click="$dispatch('openCreateBusinessModal')">
            Add Business
        </flux:button> --}}
    </div>

    @if (session('Success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">
            {{ session('Success') }}
        </div>
    @endif

    <flux:container-sidebar>
        <div class="space-y-2">
            <div class="flex gap-4 py-2">
                <div class="w-10">#</div>
                <div class="w-1/5">Business Name</div>
                <div class="w-1/5 text-center">Registered Number</div>
                <div class="w-1/5 text-center">Set Category</div>
                <div class="w-1/5 text-center">Status</div>
                <div class="w-1/5 text-center">Action</div>
            </div>
            @foreach ($businesses as $item)
                <div class="flex gap-4">
                    <div class="w-10">{{ $loop->iteration }}</div>
                    <div class="w-1/5">{{ $item->name }}</div>
                    <div class="w-1/5 text-center">{{ $item->npwp }}</div>
                    <div class="w-1/5 text-center">{{ $item->setCategory?->name ?? '' }}</div>
                    <div class="w-1/5 text-center">
                        {{ $item->status }}
                    </div>
                    <div class="w-1/5 text-center flex gap-2 justify-center">
                        <flux:tooltip content="Edit Business">
                            <flux:button
                                wire:click="$dispatch('openEditBusinessModal', { id: {{ $item->id }} }).global"
                                icon="pencil-square" size="sm" variant="primary" color="amber">
                            </flux:button>
                        </flux:tooltip>

                        <flux:tooltip content="See Details">
                            <flux:button variant="primary" wire:click='openDetailModal({{ $item->id }})'
                                icon="eye" size="sm"></flux:button>
                        </flux:tooltip>
                    </div>
                </div>
            @endforeach
            <flux:modal name="detail-business">
                <div class="mt-4 space-y-4 md:min-w-lg">
                    <div class="">
                        Detail of Business
                    </div>

                    <flux:separator text="Account Info"></flux:separator>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Email</div>
                        <div class="w-2/3">: {{ $business?->user?->email }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Status</div>
                        <div class="w-2/3">: {{ $business?->status }}</div>
                    </div>

                    <flux:separator text="Business Info"></flux:separator>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Business Name</div>
                        <div class="w-2/3">: {{ $business?->name }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Registered Number</div>
                        <div class="w-2/3">: {{ $business?->npwp }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Registered Address</div>
                        <div class="w-2/3">: {{ $business?->address }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Selected Category</div>
                        <div class="w-2/3">: {{ $business?->setCategory?->name ?? '-' }}</div>
                    </div>

                    <flux:separator text="Bank Info"></flux:separator>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Bank</div>
                        <div class="w-2/3">: {{ $business?->bank }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Account Number</div>
                        <div class="w-2/3">: {{ $business?->account_number }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Account Name</div>
                        <div class="w-2/3">: {{ $business?->account_name }}</div>
                    </div>

                    <flux:separator text="Representative"></flux:separator>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Representative</div>
                        <div class="w-2/3">: {{ $business?->representative }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Phone Number</div>
                        <a target="_blank" href="https://wa.me/{{ $business?->phone }}" class="w-2/3">:
                            {{ $business?->phone }}</a>
                    </div>
                </div>
            </flux:modal>
        </div>
        <div class="mt-4">
            {{ $businesses->links() }}
        </div>
    </flux:container-sidebar>

    @livewire('business-modal')
</div>
