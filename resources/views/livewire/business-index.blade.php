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
                <div class="w-1/5 text-center">Entity</div>
                <div class="w-1/5 text-center">Registered Number</div>
                <div class="w-1/5 text-center">Status</div>
                <div class="w-1/5 text-center">Action</div>
            </div>
            @foreach ($businesses as $item)
                <div class="flex gap-4">
                    <div class="w-10">{{ $loop->iteration }}</div>
                    <div class="w-1/5">{{ $item->name }}</div>
                    <div class="w-1/5 text-center">{{ $item->entity }}</div>
                    <div class="w-1/5 text-center">{{ $item->number }}</div>
                    <div class="w-1/5 text-center">
                        {{ $item->status == 'approved' ? "Accepted as {$item->user->member} customer" : $item->user->business }}
                    </div>
                    <div class="w-1/5 text-center">
                        <flux:tooltip content="Edit Business">
                            <flux:button 
                                wire:click="$dispatch('openEditBusinessModal', { id: {{ $item->id }} }).global"
                                icon="pencil-square"
                                size="sm" variant="primary" color="amber">
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
                <form wire:submit='save' class="mt-4 space-y-4 md:min-w-lg">
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
                        @if ($business?->status != 'approved')
                            <div class="w-2/3">: {{ $business?->status }}</div>
                        @else
                            <div class="w-2/3 text-green-500">: {{ $business?->status }} as
                                {{ $business?->user?->member }} customer</div>
                        @endif
                    </div>
                    <flux:separator text="Business Info"></flux:separator>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Business Name</div>
                        <div class="w-2/3">: {{ $business?->name }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Business Entity</div>
                        <div class="w-2/3">: {{ $business?->entity }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Registered Number</div>
                        <div class="w-2/3">: {{ $business?->number }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Registered Address</div>
                        <div class="w-2/3">: {{ $business?->address }}</div>
                    </div>
                    <flux:separator text="Representative"></flux:separator>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Representative</div>
                        <div class="w-2/3">: {{ $business?->representative }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Job Title/Position</div>
                        <div class="w-2/3">: {{ $business?->position }}</div>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Phone Number</div>
                        <a target="_blank" href="https://wa.me/{{ $business?->phone }}" class="w-2/3">:
                            {{ $business?->phone }}</a>
                    </div>
                    <div class="flex gap-4 text-start">
                        <div class="w-1/3">Email</div>
                        <div class="w-2/3">: {{ $business?->email }}</div>
                    </div>
                    <div class="flex justify-center flex-wrap gap-4">
                    </div>
                </form>
            </flux:modal>
        </div>
        <div class="mt-4">
            {{ $businesses->links() }}
        </div>
    </flux:container-sidebar>

    @livewire('business-modal')
</div>
