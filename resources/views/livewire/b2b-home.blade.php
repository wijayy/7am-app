<div>
    <div class="bg-center bg-no-repeat bg-cover w-full h-screen flex"
        style="background-image: url({{ asset('assets/hero.jpg') }}); background-position: 50% 45%;">
        <flux:container class="flex h-full items-center justify-end">
            <div
                class="w-7/12 h-fit bg-white/20 rounded-lg p-4 backdrop-blur-xs flex flex-col justify-center gap-2 md:gap-4">
                <div class="text-xl md:text-4xl text-black font-semibold md:leading-loose ">Simplify Your Business Purchasing</div>
                <div class="text-sm md:text-lg text-neutral-800">Discover a smarter way to order office and business essentials — fast,
                    reliable, and efficient.</div>

                <flux:button variant='primary' as href="{{ route('shop.index') }}" class="w-fit">Shop Now</flux:button>
            </div>
        </flux:container>
    </div>
    @livewire('feature')

    <flux:container class="mt-4">
        <div class="text-xl text-center md:text-2xl font-semibold md:leading-loose">Explore Our Product Range</div>
        <div class="text-sm text-center md:text-lg">Browse through our complete catalog of business-ready products
            designed to support your company’s needs.</div>
        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($products as $item)
                <a href="{{ route('shop.show', ['slug' => $item->slug]) }}" class="text-center">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                        class="rounded-lg shadow mb-2">
                    <p class="font-semibold">{{ $item->name }}</p>
                    <p class="text-gray-500">Rp. {{ number_format($item->price, 0, ',', '.') }}</p>
                </a>
            @endforeach
        </div>

        <div class="flex justify-center mt-4">
            <flux:button as href="{{ route('shop.index') }}" variant="primary">
                <span>Explore More</span>
                <flux:icon.arrow-long-right class="">
                </flux:icon.arrow-long-right>
            </flux:button>
        </div>
    </flux:container>


    @livewire('newsletter')


</div>
