<div class="bg-center bg-no-repeat bg-cover mt-4" style="background-image: url({{ asset('assets/newsletter.jpg') }})">
    <div class="bg-black/50 w-full h-full bg-opacity-10 py-10">
        <div class="w-[98%] mx-auto text-white py-10">
            <flux:container class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-6">
                <!-- Text -->
                <div class="w-full text-center md:w-[60%]">
                    <h2 class="text-2xl font-semibold tracking-wide">SUBSCRIBE</h2>
                    <p class="text-gray-300 mt-2">
                        Join our mailing list and receive insights, promotions, and the newest
                        product information directly to your inbox.
                    </p>
                </div>

                <!-- Form -->
                @if (session()->has('newsletter'))
                    <div class="text-red-500 text-sm font-semibold">{{ session('newsletter') }}
                    </div>
                @endif
                <form wire:submit='save' class="flex gap-4 items-end">
                    <flux:input wire:model.live='email' class="mt-4" placeholder="Input Your Email Address">
                    </flux:input>
                    <flux:button type="submit" variant="danger">Subscribe</flux:button>
                </form>
            </flux:container>
        </div>
    </div>

</div>
