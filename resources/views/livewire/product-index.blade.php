<div class="space-y-4">
    <flux:session>All Product</flux:session>
    <div class=""></div>
    <flux:container-sidebar>
        <div class="flex justify-between gap-4 ">
            <flux:input wire:model.live='search' placeholder='Search a Product' size='sm'></flux:input>
            <flux:button variant="primary" wire:click='sync' icon="plus" size="sm">Sync</flux:button>
        </div>
        <div class="grid grid-cols-14 min-w-4xl font-semibold py-2 mt-4 gap-4">
            <div class="">#</div>
            <div class="col-span-3">Product</div>
            <div class="col-span-2 text-center">SKU</div>
            <div class="col-span-2 text-center">Category</div>
            <div class="col-span-2 text-center">Price</div>
            <div class="col-span-2 text-center">MOQ</div>
            <div class="col-span-2 text-center">Action</div>
        </div>
        @foreach ($products as $key => $item)
            <div class="grid grid-cols-14 items-center min-w-4xl py-1 gap-4">
                <div class="">{{ $key + 1 }}</div>
                <div class="col-span-3 grid grid-cols-4 items-center gap-2">
                    <div class="aspect-square rounded bg-center bg-cover bg-no-repeat"
                        style="background-image: url({{ $item['image'] != '' ? $item['image'] : asset('assets/No-Picture-Found.png') }})">
                    </div>
                    <div class="col-span-3">
                        {{ $item['name'] }}
                    </div>
                </div>
                <div class="col-span-2 text-center">{{ $item['product_code'] }}</div>
                <div class="col-span-2 text-center">{{ $item['category']['name'] }}</div>
                <div class="col-span-2 text-center">Rp. {{ number_format($item['price'], 0, ',', '.') }}</div>
                <div class="col-span-2 text-center">{{ $item['moq'] }}</div>
                <div class="col-span-2 justify-center flex gap-2">
                    <flux:tooltip content="Set MOQ">
                        <flux:button size="sm" icon="pencil-square" variant="primary" color="amber"
                            wire:click="setMOQ({{ $item['id'] }})"></flux:button>
                    </flux:tooltip>
                </div>
            </div>
        @endforeach


        <flux:modal name="set-moq">
            <div class="mt-4">Adjust Information for {{ $name }}</div>
            <form wire:submit='save'>
                <div class="mt-4">
                    <flux:input wire:model.live='moq' label="Minimum Order Quantity" type="number"></flux:input>
                </div>
                <div class="mt-4">
                    <flux:input wire:model.live='maximum_order'
                        description="Set to 0 if any order quantity can be delivered the next day"
                        label="Maximum Order for Next Day Shipping" type="number"></flux:input>
                </div>
                @if ($maximum_order > 0)
                    <div class="mt-4">
                        <flux:input wire:model.live='cutoff_time'
                            description="Maximum time for order to be eligible for next day shipping"
                            label="Cutoff Time" type="time"></flux:input>
                    </div>
                @endif
                <div class="flex justify-center mt-4">
                    <flux:button type="submit" variant="primary">Save</flux:button>
                </div>
            </form>
        </flux:modal>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </flux:container-sidebar>
</div>
