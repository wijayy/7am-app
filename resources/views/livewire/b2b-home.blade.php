<div>
    <div class="bg-center bg-no-repeat bg-cover w-full h-screen flex"
        style="background-image: url({{ asset('assets/b2b/landing/banner.png') }}); background-position: 50% 45%;">
        <flux:container class="flex h-full items-center justify-start">
            <div
                class="w-7/12 h-fit bg-white rounded-lg p-4 backdrop-blur-xs flex flex-col justify-center gap-2 md:gap-4">
                <div class="text-xl md:text-4xl text-black font-semibold md:leading-loose ">Simplify Your Business Purchasing</div>
                <div class="text-sm md:text-lg text-neutral-800">Discover a smarter way to order office and business essentials — fast,
                    reliable, and efficient.</div>

                <a class="bg-[#D4A373] text-white py-2 px-4 rounded" href="{{ route('shop.index') }}">Shop Now</a>
            </div>
        </flux:container>
    </div>
    @livewire('feature')

    <flux:container class="mt-[180px] bg-white p-8 rounded-lg shadow-lg mb-16">
        <div class="text-xl text-center md:text-2xl lg:text-4xl font-semibold md:leading-loose">Explore Our Product Range</div>
        <div class="text-sm text-center md:text-lg">Browse through our complete catalog of business-ready products
            designed to support your company’s needs.</div>
        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($products as $item)
                <a href="{{ route('shop.show', ['slug' => $item->slug]) }}" class="text-center mx-1 my-4">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                        class="rounded-lg shadow mb-2">

                    <div class="px-2">
                        <div class="flex justify-between items-center mb-2">
                            <p class="font-semibold text-xl">{{ $item->name }}</p>
                            <p class="text-gray-500">Category : {{ $item->freshness }}</p>
                        </div>
                        <p class="text-[#D4A373] text-left">Rp. {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="flex justify-end mt-4">
            <a href="{{ route('shop.index') }}" class="bg-[#D4A373] text-white flex items-center gap-2 py-2 px-4 rounded-md">
                <span>Explore More</span>
                <flux:icon.arrow-long-right class="">
                </flux:icon.arrow-long-right>
            </a>
        </div>
    </flux:container>


    @livewire('newsletter')


</div>
