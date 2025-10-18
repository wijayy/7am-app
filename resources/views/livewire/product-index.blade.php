{{-- @dd($products) --}}

<div class="space-y-4">
    <flux:session>All Product</flux:session>

    <flux:container-sidebar>
        <div class="flex justify-end">
            <flux:button variant="primary" as href="{{ route('product.create') }}" icon="plus" size="sm">Add
                Product</flux:button>
        </div>
        <div class="grid grid-cols-14 min-w-3xl font-semibold py-2 gap-4">
            <div class="">#</div>
            <div class="col-span-3">Product</div>
            <div class="col-span-2 text-center">SKU</div>
            <div class="col-span-2 text-center">Category</div>
            <div class="col-span-2 text-center">Price</div>
            <div class="col-span-2 text-center">Freshness</div>
            <div class="col-span-2 text-center">Action</div>
        </div>
        @foreach ($products as $key => $item)
            <div class="grid grid-cols-14 items-center min-w-3xl py-1 gap-4">
                <div class="">{{ $key + 1 }}</div>
                <div class="col-span-3 flex items-center gap-2">
                    <div class="size-12 rounded bg-center bg-cover bg-no-repeat"
                        style="background-image: url({{ $item['image']['url'] != '' ? $item['image']['url'] : asset('assets/No-Picture-Found.png') }})">
                    </div>
                    <div class="">
                        {{ $item['name'] }}
                    </div>
                </div>
                <div class="col-span-2 text-center">{{ $item['product_code'] }}</div>
                <div class="col-span-2 text-center">{{ $item['product_categories_string'] }}</div>
                <div class="col-span-2 text-center">{{ $item['sell_price_per_unit_currency_format'] }}</div>
                <div class="col-span-2 text-center">{{ $item['deleted_at'] }}</div>
                <div class="col-span-2 justify-center flex gap-2">
                    {{-- <flux:tooltip content="Edit Product">
                        <flux:button size="sm" as href="{{ route('product.edit', ['slug' => $item->slug]) }}"
                            icon="pencil-square" variant="primary" color="teal"></flux:button>
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
                            <flux:button wire:click='delete({{ $item->id }})' variant="danger">Delete</flux:button>
                        </div>
                    </flux:modal> --}}
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </flux:container-sidebar>
</div>
