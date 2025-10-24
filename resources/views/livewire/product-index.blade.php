{{-- @dd($products) --}}

<div class="space-y-4">
    <flux:session>All Product</flux:session>
    <div class=""></div>
    <flux:container-sidebar>
        <div class="flex justify-between gap-4 ">
            <flux:input wire:model.live='search' placeholder='Search a Product' size='sm'></flux:input>
            <flux:button variant="primary" wire:click='sync' icon="plus" size="sm">Sync</flux:button>
        </div>
        <div class="grid grid-cols-14 min-w-4xl font-semibold py-2 gap-4">
            <div class="">#</div>
            <div class="col-span-3">Product</div>
            <div class="col-span-2 text-center">SKU</div>
            <div class="col-span-2 text-center">Category</div>
            <div class="col-span-2 text-center">Price</div>
            <div class="col-span-2 text-center">Freshness</div>
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
                <div class="col-span-2 text-center">{{ $item['product_categories_string'] }}</div>
                <div class="col-span-2 text-center">{{ $item['price'] }}</div>
                <div class="col-span-2 text-center">{{ $item['active'] }}</div>
                <div class="col-span-2 justify-center flex gap-2">

                </div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </flux:container-sidebar>
</div>
