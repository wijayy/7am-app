<div class="mt-28">

    <flux:container class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Left: Product Image -->
        <div class="flex justify-center">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded-2xl shadow-md w-full max-w-md">
        </div>

        <!-- Right: Product Info -->
        <div>
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500 dark:text-neutral-400 mb-4">
                <a href="/" class="hover:underline">Home</a> >
                <a href="/shop" class="hover:underline">Shop</a> >
                <span>{{ $product->name }}</span>
            </nav>

            <!-- Title & Category -->
            <h1 class="text-3xl font-bold capitalize text-gray-800 dark:text-gray-200">{{ $product->name }}</h1>
            {{-- <p class="text-gray-500 mb-2">{{ $product->category->name }}</p> --}}

            <!-- Price & MOQ -->
            <p class="text-2xl font-semibold text-mine-300 dark:text-rose-500">Rp.
                {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500 mb-4">MOQ: {{ $product->moq }}</p>

            <!-- Description -->
            <p class="text-gray-700 dark:text-neutral-300 mb-6">
                {{ $product->description }}
            </p>

            <!-- Quantity & Add to Cart -->
            <div class="flex items-center gap-4 mb-6">
                <flux:input wire:model.live='qty' min="{{ $product->moq }}" class="w-24!" type="number"></flux:input>
                <flux:button variant="primary" wire:click='addToCart' color="green"
                    class=" font-semibold px-6 py-3 rounded-lg shadow">
                    Add to Cart
                </flux:button>
            </div>
            <div class="mt-4">
                <x-action-message class="me-3" on="created">
                    {{ __("$product->name is now in your cart. You may proceed to confirm your order") }}
                </x-action-message>
                <x-action-message class="me-3" on="updated">
                    {{ __("$product->name is already in the cart, the quantity is updated.") }}
                </x-action-message>
            </div>
        </div>
    </flux:container>
    <flux:container class="my-4">
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
