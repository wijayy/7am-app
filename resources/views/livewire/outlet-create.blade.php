<div class="space-y-4">
    <div :dismissible='false' name='outlet-create'>
        <div class="mt-4 font-semibold text-center">{{ $title }}</div>

        <form wire:submit='save' class="mt-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
                <flux:input type="file" aspect="3/4" wire:model.live='image' preview="{{ $preview }}">
                </flux:input>
            </div>
            <div class="grid grid-cols-1  md:grid-cols-2 gap-4">
                <flux:input wire:model.live='name' label="Outlet Name" required></flux:input>
                <flux:input wire:model.live='address' label="Outlet Address" required></flux:input>
                <flux:input wire:model.live='link_grab' type="url" label="Grab Link" required></flux:input>
                <flux:input wire:model.live='link_gojek' type="url" label="Gojek Link" required></flux:input>
                <flux:input wire:model.live='start_time' type="time" label="Start Working Hour" required>
                </flux:input>
                <flux:input wire:model.live='end_time' type="time" label="End Working Hour" required></flux:input>
            </div>

            <flux:separator text="Outlet Section">
            </flux:separator>
            <div class="space-y-4">
                <div class="grid gri1 gap-4 md:grid-cols-2">
                    @foreach ($sections as $key => $item)
                        <div class="flex items-end gap-1">
                            <div class="w-full">
                                <flux:input wire:model.live='sections.{{ $key }}.name' label="Section Name"
                                    required>
                                </flux:input>
                            </div>
                            <div class="">
                                <flux:button icon="trash" wire:click='deleteSection({{ $key }})'
                                    variant="danger"></flux:button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <flux:button icon="plus" variant="primary" wire:click='addSection' class="w-full!">Add Section
                </flux:button>
            </div>

            <flux:separator text="Outlet Gallery">
            </flux:separator>
            <div class=" grid grid-cols-1 items-center sm:grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($images as $key => $item)
                    <div class="" wire:key="image-{{ $item['id'] ?? $item['temp_id'] }}">
                        <flux:input type="file" wire:model.live='images.{{ $key }}.image'
                            :preview="$item['image']" label="Image">
                        </flux:input>
                        <div class="">
                            <flux:button icon="trash" wire:click='deleteImage({{ $key }})' variant="danger">
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                <flux:button icon="plus" variant="primary" wire:click='addImage' class="w-full!">Add Image
                </flux:button>
            </div>
            <div class="mt-4">
                <flux:button variant="primary" type="submit">Submit
                </flux:button>
            </div>
        </form>
    </div>
</div>
