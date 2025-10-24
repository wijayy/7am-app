<div class="mt-28">

    <flux:container class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white py-20 px-6 rounded-3xl shadow-lg">
        <!-- Left: Product Image -->
        <div class="flex justify-center">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded-2xl shadow-md w-full max-w-md">
        </div>

        <!-- Right: Product Info -->
        <div class="w-[80%] space-y-8">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500 dark:text-neutral-400">
                <a href="/shop" class="hover:underline">Shop</a> >
                <span>{{ $product->name }}</span>
            </nav>

            <!-- Title & Category -->
            <div>
                <h1 class="text-3xl font-bold capitalize text-[#4B2E05]">{{ $product->name }}</h1>
                <p class="text-gray-500 mb-2 text-sm">Category : {{ $product->category->name }}</p>
            </div>

            <!-- Price & MOQ -->
            <div>
                <p class="text-2xl font-semibold text-[#4B2E05]">Rp.
                    {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 mb-4">Minimum Order Quantity: {{ $product->moq }}</p>
            </div>

            <!-- Description -->
            <p class="text-gray-700 dark:text-neutral-300">
                {{ $product->description }}
            </p>

            <!-- Quantity & Add to Cart -->
            <div>
                <div class="flex items-center gap-4">
                    <flux:input wire:model.live='qty' min="{{ $product->moq }}" class="w-24!" type="number"></flux:input>

                    <div
                        wire:click='addToCart'
                        class="flex px-6 space-x-2 h-10 rounded-lg shadow text-sm cursor-pointer hover:bg-[#b8875c] transition justify-start items-center bg-[#D4A373] text-white">
                        <flux:icon icon="shopping-bag" variant="outline" class="" />
                        <button>
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="mt-2">
                    <x-action-message class="me-3" on="created" class="text-green-600">
                        {{ __("$product->name is now in your cart. You may proceed to confirm your order") }}
                    </x-action-message>
                    <x-action-message class="me-3" on="updated" class="text-green-600">
                        {{ __("$product->name is already in the cart, the quantity is updated.") }}
                    </x-action-message>
                </div>
            </div>
        </div>
    </flux:container>
    <flux:container class="my-12">
        <div class="text-xl text-center md:text-2xl font-semibold md:leading-loose">You May Also Like</div>
        <div class="text-sm text-center md:text-lg">Here are similar products carefully selected to support your
            business needs.</div>
        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($products as $item)
                <a href="{{ route('shop.show', ['slug' => $item->slug]) }}" class="text-center">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="rounded-lg shadow mb-2">
                    <p class="font-semibold">{{ $item->name }}</p>
                    <p class="text-gray-500 dark:text-neutral-300">Rp. {{ number_format($item->price, 0, ',', '.') }}
                    </p>
                </a>
            @endforeach
        </div>
    </flux:container>

    @livewire('newsletter')
</div>
