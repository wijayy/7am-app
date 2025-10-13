<div>
    <flux:secondary-hero text="My Cart"></flux:secondary-hero>

    <flux:container>

        <div class="flex gap-8 mt-8 flex-wrap md:flex-nowrap">
            <div class="w-full overflow-x-auto md:w-3/4 space-y-2">
                <div
                    class="flex gap-4 text-sm font-semibold md:text-base px-4 min-w-xl md:min-w-0 bg-gray-200 dark:bg-neutral-800 py-4">
                    <div class="w-5/12">Product</div>
                    <div class="w-2/12 text-center">Unit Price</div>
                    <div class="w-2/12 text-center">Quantity</div>
                    <div class="w-2/12 text-center">Subtotal</div>
                    <div class="w-1/12 text-center">Action</div>
                </div>
                @forelse ($carts as $key => $item)
                    <div class="flex px-4 gap-4 text-sm md:text-base items-center min-w-xl md:min-w-0">
                        <a href="{{ route('shop.show', ['slug' => $item->product->slug]) }}"
                            class="w-5/12 flex items-center gap-2">
                            <div class="size-20 rounded bg-center bg-cover bg-no-repeat"
                                style="background-image: url({{ asset("storage/{$item->product->image}") }})"></div>
                            <div class="">
                                <div class="font-semibold">{{ $item->product->name }}</div>
                                <div class="text-xs md:text-sm">{{ $item->product->category->name }}</div>
                            </div>
                        </a>
                        <div class="w-2/12 text-center">Rp. {{ number_format($item->product->price, 0, ',', '.') }}
                        </div>
                        <div class="w-2/12 text-center gap-1 flex">
                            <flux:button wire:click='minus({{ $item->id }})' icon="minus"></flux:button>
                            <flux:input wire:model.live='qty.{{ $key }}.qty'
                                class="w-16! text-center! rounded-none!" wire:change='change'
                                min="{{ $item->product->moq }}"></flux:input>
                            <flux:button wire:click='plus({{ $item->id }})' icon="plus"></flux:button>
                        </div>
                        <div class="w-2/12 text-center">Rp.
                            {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}</div>
                        <div class="w-1/12 text-center">
                            <flux:button size="sm" wire:click='delete({{ $item->id }})' variant="danger"
                                icon="x-mark"></flux:button>
                        </div>
                    </div>
                @empty
                    <div class="flex justify-center items-center w-full h-80 font-semibold text-gray-500">
                        Looks like your cart is lonely. Add products to make it happy!
                    </div>
                @endforelse
            </div>
            <div class="md:w-1/4 w-full space-y-4 sticky">
                <div class=" bg-gray-300 p-4 h-fit dark:bg-neutral-700 rounded">
                    <div class="md:text-lg font-semibold text-center">Order summary</div>
                    <flux:separator class="h-1!"></flux:separator>

                    <div class="flex text-xs md:text-sm mt-4 justify-between">
                        <div class="">Subtotal ({{ $carts->count() }} items)</div>
                        <div class="">Rp. {{ number_format($subtotal, 0, ',', '.') }}</div>
                    </div>
                    @if ($c ?? false)
                        <div class="flex text-xs md:text-sm mt-4 justify-between">
                            <div class="">Coupon</div>
                            <div class="">{{ $c->code }}</div>
                        </div>
                        <div class="flex text-xs md:text-sm mt-4 justify-between">
                            <div class="">Discount</div>
                            <div class="">Rp. {{ number_format($this->countDiscount(), 0, ',', '.') }}</div>
                        </div>
                    @endif
                    <div class="flex justify-center mt-4">
                        <flux:button wire:click='checkout' variant="primary" color="green">Checkout</flux:button>
                    </div>
                </div>

                @if ($cpn)
                    <div class=" bg-gray-300 p-4 h-fit space-y-4 items-end dark:bg-neutral-700 rounded">
                        <div class="flex gap-4">

                            <div class="size-8">
                                <flux:button size='sm' icon="x-mark" wire:click='pn({{ 0 }})'
                                    variant="primary" color="slate"></flux:button>
                            </div>
                            <flux:input wire:model.live='coupon' size="sm"
                                placeholder="Enter your coupon here ...">
                            </flux:input>
                        </div>
                        @if ($c)
                            <div class="text-mine-200">Coupon applied</div>
                        @endif
                    </div>
                @else
                    <flux:button variant="primary" wire:click='pn({{ 1 }})' color="gray" class="w-full!">
                        Have a coupon?</flux:button>
                @endif

            </div>
        </div>
    </flux:container>

    @livewire('newsletter')
</div>
