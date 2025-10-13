<div class="mt-20">
    <flux:container>
        <div class="text-xl text-center md:text-xl font-semibold md:leading-loose">Complete Your Order</div>
        <div class="text-sm text-center md:text-lg">Double-check everything before hitting the finish line.</div>

        <flux:separator text="Shipping"></flux:separator>

        <div class="border-mine-200 border mt-4 p-4 bg-mine-200/5 rounded-lg w-full flex justify-between items-center">
            <div class="">
                <div class="text-sm md:text-md font-semibold">{{ $address->name }} / {{ $address->phone }}</div>
                <div class="mt-2">{{ $address->address }}</div>
            </div>
            <flux:modal.trigger class="trigger" name="address">
                <flux:button variant="primary" color="green">Change</flux:button>
            </flux:modal.trigger>
        </div>

        <div class="mt-4">
            <flux:input type="date" wire:model.live='shipping_date' min="{{ $min }}" :label="'Shipping Date'">
            </flux:input>
        </div>

        <flux:modal name="address">
            <div class="md:text-lg font-semibold">Choose Your Address</div>
            @foreach ($addresses as $item)
                <div wire:click='changeAddress({{ $item->id }})'
                    class=" cursor-pointer border mt-4 p-4  {{ $item->id == $address->id ? 'border-mine-200 bg-mine-200/5' : 'border-gray-200' }} rounded-lg w-full space-y-4">
                    <div class="">
                        <div class="text-sm md:text-md font-semibold">{{ $item->name }} / {{ $item->phone }}</div>
                        <div class="mt-2">{{ $item->address }}</div>
                    </div>
                    <a href="" class="underline underline-offset-2">Edit address</a>
                </div>
            @endforeach
        </flux:modal>

        <flux:separator text="Products"></flux:separator>

        <div class="w-full overflow-x-auto space-y-2">
            <div class="flex gap-4 text-sm font-semibold md:text-base px-4 min-w-xl md:min-w-0">
                <div class="w-5/12">Product</div>
                <div class="w-3/12 text-center">Unit Price</div>
                <div class="w-2/12 text-center">Quantity</div>
                <div class="w-3/12 text-center">Subtotal</div>
            </div>
            @foreach ($carts as $key => $item)
                <div class="flex px-4 gap-4 text-sm md:text-base items-center min-w-xl md:min-w-0">
                    <div class="w-5/12 flex items-center gap-2">
                        <div class="size-20 rounded bg-center bg-cover bg-no-repeat"
                            style="background-image: url({{ asset("storage/{$item->product->image}") }})"></div>
                        <div class="">
                            <div class="font-semibold">{{ $item->product->name }}</div>
                            <div class="text-xs md:text-sm">{{ $item->product->category->name }}</div>
                        </div>
                    </div>
                    <div class="w-3/12 text-center">Rp. {{ number_format($item->product->price, 0, ',', '.') }}
                    </div>
                    <div class="w-2/12 text-center">
                        {{ $item->qty }} Pcs
                    </div>
                    <div class="w-3/12 text-center">Rp.
                        {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>

        <flux:separator text="Order summary"></flux:separator>

        <div class="flex justify-end">
            <div class="w-full md:w-1/3 p-4 rounded-sm bg-gray-200 space-y-2 dark:bg-neutral-800">
                <div class="flex justify-between items-center">
                    <div class="">Subtotal ({{ $carts->count() }} items)</div>
                    <div class="">Rp. {{ number_format($subtotal, 0, ',', '.') }}</div>
                </div>
                @if ($coupon)
                    <div class="flex justify-between items-center">
                        <div class="">Coupon</div>
                        <div class="">{{ $coupon->code }}</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="">Discount</div>
                        <div class="">Rp. {{ number_format($discount, 0, ',', '.') }}</div>
                    </div>
                @endif
                <div class="flex justify-between items-center">
                    <div class="">Payment Method</div>
                    <div class="">
                        <img src="{{ asset('assets/bca.png') }}" alt="">
                    </div>
                </div>
                <flux:separator></flux:separator>
                <div class="flex justify-between items-center">
                    <div class="">Total</div>
                    <div class="">Rp. {{ number_format($total, 0, ',', '.') }}</div>
                </div>
                <div class="mt-4 flex justify-center">
                    <flux:button wire:click='checkout' variant="primary" color="green">Checkout</flux:button>
                </div>
            </div>
        </div>
    </flux:container>

    @livewire('newsletter')
</div>
