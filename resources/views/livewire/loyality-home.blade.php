<div class="space-y-4">
    <div class="w-full h-screen bg-center bg-cover bg-no-repeat"
        style="background-image: url({{ asset('assets/loyality.jpg') }})">
        <flux:container class="flex h-full items-center justify-center">
            <div class=" h-fit rounded-lg p-4 backdrop-blur-sm flex flex-col items-center justify-center gap-2">
                <div class="text-xl md:text-5xl text-white text-center font-semibold  md:leading-loose ">Membership
                    Program</div>
                <div class="text-sm md:text-xl text-balance text-white text-center">Collect points, unlock rewards, and
                    enjoy special perks</div>

                <div class="text-sm md:text-xl mt-8 font-semibold text-balance text-mine-300 text-center">Don’t miss out!
                    Visit our outlet and register as a member at the cashier.</div>

                {{-- <flux:button variant='primary' as href="{{ route('reservation.create') }}" class="w-fit">Reserve now
                </flux:button> --}}
            </div>
        </flux:container>
    </div>

    <flux:container class="mt-16!">
        <div class="text-center text-xl font-semibold">How Our Membership Works</div>
        <div class="text-lg text-center mt-2">Start earning rewards with every purchase and unlock exclusive benefits as
            a valued member
        </div>

        <div class="grid gap-4 md:gap-12 mt-8 grid-cols-3">
            <div class="rounded-lg bg-mine-200/10  flex flex-col items-center p-8">
                <div class="rounded-full bg-mine-300 p-4">
                    <flux:icon class="md:size-10!  stroke-white!" icon="credit-card"></flux:icon>
                </div>
                <div class="mt-4 text-sm md:text-lg text-mine-200 font-semibold text-center">Earn Points</div>
                <div class="mt-4 text-center text-xs md:text-sm font-semibold">Come shop at our outlet and earn 1 point
                    for every 10,000
                    spent. Get
                    double points
                    on your birthday!</div>
            </div>
            <div class="rounded-lg bg-mine-200/10  flex flex-col items-center p-8">
                <div class="rounded-full bg-mine-200 p-4">
                    <flux:icon class="md:size-10! stroke-white!" icon="gift"></flux:icon>
                </div>
                <div class="mt-4 text-sm md:text-lg text-mine-200 text-center font-semibold">Redeem Rewards</div>
                <div class="mt-4 text-center text-xs md:text-sm font-semibold">Use your points for exclusive discounts,
                    free items, and
                    special offers at your favorite stores.</div>
            </div>
            <div class="rounded-lg bg-mine-200/10  flex flex-col items-center p-8">
                <div class="rounded-full bg-amber-300 p-4">
                    <flux:icon class="md:size-10! stroke-white!" icon="trophy"></flux:icon>
                </div>
                <div class="mt-4 text-sm md:text-lg text-mine-200 text-center font-semibold">Get Rewarded</div>
                <div class="mt-4 text-xs md:text-sm text-center font-semibold">Enjoy the benefits! After redeeming,
                    you’ll receive discounts, freebies, and special perks that make your shopping even more exciting.
                </div>
            </div>
        </div>
    </flux:container>

    <flux:container>
        <div class="text-center text-xl mt-16 font-semibold">Shop More, Save More!</div>
        <div class="text-lg text-center mt-2">Receive your card and unlock discounts with every transaction
        </div>

        <div class="grid grid-cols-1 mt-4 md:grid-cols-3 gap-4">
            @foreach ($cards as $item)
                <div class="rounded-lg p-4 bg-mine-100 dark:bg-neutral-700">
                    <div class="aspect-16/10 bg-center rounded bg-no-repeat bg-cover"
                        style="background-image: url({{ asset("storage/$item->card") }})"></div>
                    <div class="font-semibold mt-4 text-center">{{ $item->name }}</div>
                    <div class="">All {{ $item->usage }} enjoy {{ $item->discount }}% off on
                        {{ $item->discount_type }}</div>
                </div>
            @endforeach
        </div>
    </flux:container>

    <flux:container>
        <div class="text-center text-xl mt-16  font-semibold">Unlock Your Benefits</div>
        <div class="text-lg text-center mt-2">Exchange your points and enjoy instant benefits
        </div>

        <div class="grid grid-cols-1 mt-4 md:grid-cols-5 gap-4 mb-16">
            @foreach ($redeems as $item)
                <div class="rounded-lg p-4 bg-mine-200/40">
                    <div class="font-semibold mt-4 text-center">{{ $item->name }}</div>
                    <div class="mt-2 text-center">Get {{ $item->reward }}</div>
                </div>
            @endforeach
        </div>
    </flux:container>

    <div class="w-full bg-center bg-cover bg-no-repeat py-8"
        style="background-image: url({{ asset('assets/track-membership.jpg') }})">
        <flux:container class="flex justify-center">
            <div class="backdrop-blur-sm p-4 w-fit rounded-lg">

                <div class="text-xl text-center text-white font-semibold">Are you already part of our members club?
                </div>
                <div class="text-center text-white mt-2">Check your membership details with your name and card code.
                </div>

                @if (session()->has('error'))
                    <div class="mt-4 text-center font-semibold text-mine-300">
                        {{ session()->get('error') }}
                    </div>
                @endif

                <div class="flex justify-center gap-4 mt-4">
                    <div class="flex gap-4">
                        <flux:input wire:model.live='name' placeholder="Member Name"></flux:input>
                        <flux:input wire:model.live='Code' only_number placeholder="Card Code"></flux:input>
                    </div>
                    <flux:button wire:click='track' variant="primary">Track</flux:button>
                </div>
            </div>
        </flux:container>
    </div>



</div>
