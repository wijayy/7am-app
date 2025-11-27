<flux:container
    class="mt-32 mb-8 min-h-[55vh] bg-white dark:bg-gray-500 py-8 px-4 md:px-8 lg:px-16 rounded-xl shadow-md w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Address')" :subheading="__('Keep your billing and delivery details up to date for smooth transactions.')">
        @if (session()->has('info'))
            <div class="text-sky-400! text-sm font-semibold">{{ session('info') }}</div>
        @endif
        <div class="flex flex-col gap-4">
            @foreach ($addressess as $item)
                <div class="p-4 flex items-center justify-between rounded-lg border-2 border-mine-200">
                    <div class="shrink">
                        <div class="text-sm md:text-base">{{ $item->name }} / {{ $item->phone }}</div>
                        <div class="text-xs md:text-sm">{{ $item->address }}</div>
                        <div class="text-xs md:text-sm">{{ $item->regency->name }} - {{ $item->district->name }} -
                            {{ $item->village->name }}</div>
                    </div>
                    <div class="flex gap-2">
                        <flux:tooltip content="Edit Product">
                            <flux:button size="sm" wire:click='openEditModal({{ $item->id }})'
                                icon="pencil-square" variant="primary" color="teal">
                            </flux:button>
                        </flux:tooltip>
                        <flux:modal.trigger class="trigger" name="delete-{{ $item->id }}">
                            <flux:tooltip content="Delete Product">
                                <flux:button size="sm" variant='danger' icon="trash"></flux:button>
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
            <flux:tooltip content="Add Address">
                <flux:button class="w-full!" wire:click='openCreateModal' variant="primary" icon="plus">
                </flux:button>
            </flux:tooltip>
        </div>

        <flux:modal name="create-address">
            <div class="">{{ $id ?? false ? 'Edit Address' : 'Add New Address' }}</div>
            <form wire:submit='save' class="w-full space-y-4 mt-4 md:min-w-lg">
                <flux:input label="Place Name/Person Name" wire:model.live='name' required></flux:input>
                <flux:input oninput="this.value = this.value.replace(/[^0-9]/g, '')" label="Phone Number"
                    wire:model.live='phone' required></flux:input>
                <flux:select label="Regency" wire:model.live='regency' required>
                    <flux:select.option value="">--Select Regency--</flux:select.option>
                    @foreach ($regencies as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select label="District" wire:model.live='district' wire:key="district-{{ $regency }}"
                    required>
                    <flux:select.option value="">--Select District--</flux:select.option>
                    @foreach ($districts as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select label="Village" wire:model.live='village' wire:key="village-{{ $district }}" required>
                    <flux:select.option value="">--Select Village--</flux:select.option>
                    @foreach ($villages as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input label="Address" wire:model.live='address' required></flux:input>
                <div class="flex justify-center">
                    <flux:button type="submit" variant="primary">Submit</flux:button>
                </div>
            </form>
        </flux:modal>
    </x-settings.layout>
</flux:container>
