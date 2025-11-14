<div class="mt-20">
    <flux:container>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="md:col-span-2 space-y-4">
                <div class="text-center text-lg font-semibold md:text-xl">{{ $outlet->name }}</div>
                <a class="flex gap-4">
                    <flux:icon.map-pin class="timer"></flux:icon.map-pin>
                    <div class="">{{ $outlet->address }}</div>
                </a>
                <div class="flex gap-4">
                    <flux:icon.clock-7 class="timer"></flux:icon.clock-7>
                    <div class="">{{ $outlet->start_time->format('H:i') }} - {{ $outlet->end_time->format('H:i') }}
                    </div>
                </div>

                <div class="">We are Available on</div>
                <div class="flex gap-2">
                    <flux:button icon="gojek" href="{{ $outlet->link_gojek }}" class="h-10 cursor-pointer">
                        <div class="">Gofood</div>
                    </flux:button>
                    <flux:button icon="grab" href="{{ $outlet->link_grab }}" class="h-10 cursor-pointer">
                        <div class="">Grabfood</div>
                    </flux:button>
                </div>

                <div class="">{!! $outlet->description !!}</div>

                <flux:button variant="primary" as href="{{ route('reservation.create', ['outlet' => $outlet->slug]) }}" class="">
                    Reserve Your Table Now!</flux:button>

            </div>
            <div class="p-4">
                <div class="rounded bg-cover bg-no-repeat bg-center aspect-3/4"
                    style="background-image: url({{ asset("storage/$outlet->image") }})"></div>
            </div>
        </div>

        <div class="mt-4 flex gap-4 w-full justify-center items-center">
            <flux:radio.group wire:model.live='open' variant="segmented" class="group">
                <flux:radio icon="layout-grid" value="gallery">Gallery</flux:radio>
                <flux:radio icon="messages-square" value="review">Review</flux:radio>
            </flux:radio.group>
        </div>

        @if ($open == 'gallery')
            <div class="my-4 grid grid-cols-2   md:grid-cols-4 gap-4">
                <div class="space-y-4">
                    @foreach ($image1 as $key => $item)
                        @if ($key < $limit)
                            <img src="{{ asset("storage/$item->image") }}" class="rounded" alt="">
                        @endif
                    @endforeach
                </div>
                <div class="space-y-4">
                    @foreach ($image2 as $key => $item)
                        @if ($key < $limit)
                            <img src="{{ asset("storage/$item->image") }}" class="rounded" alt="">
                        @endif
                    @endforeach

                </div>
                <div class="space-y-4">
                    @foreach ($image3 as $key => $item)
                        @if ($key < $limit)
                            <img src="{{ asset("storage/$item->image") }}" class="rounded" alt="">
                        @endif
                    @endforeach

                </div>
                <div class="space-y-4">
                    @foreach ($image4 as $key => $item)
                        @if ($key < $limit)
                            <img src="{{ asset("storage/$item->image") }}" class="rounded" alt="">
                        @endif
                    @endforeach
                </div>
            </div>
            @if ($limit < $maxLimit)
                <div class="flex my-4 justify-center">
                    <flux:button variant="primary" wire:click='addLimit'>Show More</flux:button>
                </div>
            @endif
        @else
            <div class=" flex flex-col my-4 gap-4">

                @foreach ($outlet->reviews as $item)
                    <div class="rounded-lg border border-black dark:border-white p-2">
                        <div class="">{{ $item->reservation->name }}</div>
                        <flux:separator></flux:separator>
                        <div class="flex gap-2">
                            @for ($i = 1; $i <= $item->rate; $i++)
                                <flux:icon.star variant="solid" class="fill-amber-300"></flux:icon.star>
                            @endfor
                            @for ($i = 5; $i > $item->rate; $i--)
                                <flux:icon.star class=""></flux:icon.star>
                            @endfor
                        </div>
                        <div class="mt-2">{{ $item->review }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </flux:container>
</div>
