<div class=" bg-center bg-no-repeat bg-cover py-10 mt-4" style="background-image: url({{ asset('assets/newsletter.jpg') }})">
    <flux:container class=" flex justify-center rounded items-center mt-8">
        <div class="w-11/12 md:w-1/2 h-2/3 p-4 bg-white/50 relative dark:bg-black/50 rounded-lg shadow">
            <div class="text-center md:text-xl font-semibold">Subscribe To Our Newsletter</div>
            <div class="text-center text-sm md:text-base">Join our mailing list and receive insights, promotions, and the newest product
                information directly to your inbox.</div>
                @if (session()->has('newsletter'))
                    <div class="text-red-500 text-sm font-semibold">{{ session('newsletter') }}
                    </div>
                @endif
            <form wire:submit='save' class="flex gap-4 items-end">
                <flux:input wire:model.live='email' class="mt-4" placeholder="Input Your Email Address"></flux:input>
                <flux:button type="submit" variant="danger">Subscribe</flux:button>
            </form>
        </div>
    </flux:container>
</div>
