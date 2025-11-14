<flux:modal name="shop-show">
    @if ($product)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Left: Product Image -->
            <div class="flex justify-center">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                    class="rounded-2xl shadow-md h-full object-cover" />
            </div>

            <!-- Right: Product Info -->
            <div class="w-[80%] space-y-8">
                <nav class="text-sm text-gray-500 dark:text-neutral-400">
                    <a href="/shop" class="hover:underline">Shop</a> >
                    <span>{{ $product->name }}</span>
                </nav>

                <div>
                    <h1 class="text-md font-bold capitalize text-[#4B2E05] dark:text-white">{{ $product->name }}</h1>
                    <p class="text-gray-500 mb-2 text-xs">Category : {{ $product->category->name }}</p>
                </div>

                <div>
                    <p class="text-md font-semibold text-[#4B2E05] dark:text-white">Rp.
                        {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mb-4">Minimum Order Quantity: {{ $product->moq }}</p>
                </div>

                <p class="text-gray-700 dark:text-neutral-300">
                    {{ $product->description }}
                </p>

                <div>
                    <div class="flex items-center gap-4">
                        <flux:input wire:model.live='qty' min="{{ $product->moq }}" class="w-24" type="number" />
                        <div wire:click='addToCart'
                            class="flex w-full justify-center items-center text-xs space-x-2 h-10 rounded-lg shadow cursor-pointer hover:bg-[#b8875c] transition bg-[#D4A373] text-white">
                            <flux:icon icon="shopping-bag" class="w-4" variant="outline" />
                            <p>Add to Cart</p>
                        </div>
                    </div>

                    <div class="mt-2">
                        <x-action-message on="created" class="text-green-600">
                            {{ __("$product->name is now in your cart. You may proceed to confirm your order") }}
                        </x-action-message>
                        <x-action-message on="updated" class="text-green-600">
                            {{ __("$product->name is already in the cart, the quantity is updated.") }}
                        </x-action-message>
                    </div>
                </div>
            </div>
        </div>

        {{-- @livewire('newsletter') --}}
    @endif
</flux:modal>
