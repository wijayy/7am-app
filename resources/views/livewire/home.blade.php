<div class="">
    <div class="bg-center bg-no-repeat bg-cover w-full h-screen flex"
        style="background-image: url({{ asset('assets/reservation/IMG_2728.jpg') }}); background-position: 50% 30%;">
        <flux:container class="flex h-full items-center justify-center">
            <div class="w-full h-fit rounded-lg p-4 flex flex-col items-center justify-center gap-2">
                <div class="text-xl md:text-5xl text-white text-center font-semibold md:leading-loose ">Book Your Perfect
                    Spot, Anytime</div>
                <div class="text-sm md:text-xl text-balance text-white text-center">Reserve your table or venue with
                    ease. Quick, reliable, and hassle-free reservations tailored for you.</div>

                <flux:button variant='primary' as href="{{ route('reservation.create') }}" class="w-fit">Reserve now
                </flux:button>
            </div>
        </flux:container>
    </div>
    <flux:container class="mt-8 mb-4">
        <div class="text-center  md:text-2xl font-semibold">Choose Your Favorite Outlets</div>
        <div class="text-center text-sm md:text-lg">Choose Your Favorite Outlets</div>

        <div class="grid grid-cols-1 mt-4 gap-4 md:grid-cols-3">
            @foreach ($outlets as $item)
                <div class="rounded-lg border bg-gray-100 dark:bg-neutral-700">
                    <div class="bg-cover rounded-t-lg bg-center bg-no-repeat aspect-3/4 w-full"
                        style="background-image: url({{ asset("storage/$item->image") }})"></div>
                    <div class="p-4">
                        <div class="font-semibold">
                            {{ $item->name }}
                        </div>
                        <div class="text-xs">{{ $item->address }}</div>
                    </div>
                    <div class="flex gap-2 p-4 pt-0!">
                        <flux:button variant="primary" as
                            href="{{ route('reservation.create', ['outlet' => $item->slug]) }}" icon="notebook-pen"
                            size="sm">Reserve</flux:button>
                        <flux:button variant="primary" as href="{{ route('outlet-show', ['slug' => $item->slug]) }}"
                            color="cyan" icon="eye" size="sm">See Detail</flux:button>
                    </div>
                </div>
            @endforeach
        </div>
    </flux:container>

    {{-- @livewire('loyality-show') --}}
</div>
