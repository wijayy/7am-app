<div>
    <flux:container class="min-h-[55vh] mt-30">
        <div class="bg-[#E8E1D7] min-h-screen py-10 flex flex-col items-center">
            <div class="max-w-7xl w-full flex flex-col lg:flex-row gap-8">

                {{-- Left Section – Cart Items --}}
                <div class="bg-white rounded-2xl p-6 flex-1 shadow">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-black">My Cart</h2>
                    </div>

                    <h4 class="font-medium text-gray-800 mb-2">Shipping</h4>
                    <div class="flex border border-gray-300 rounded-lg overflow-hidden mb-3">
                        <label class="flex-1">
                            <input type="radio" name="fulfillment" value="delivery" wire:model.live="fulfillment"
                                class="sr-only peer" checked>
                            <div
                                class="py-2 text-center cursor-pointer transition-colors bg-gray-100 text-gray-700 peer-checked:bg-[#B68B62] peer-checked:text-white">
                                Delivery
                            </div>
                        </label>

                        <label class="flex-1">
                            <input type="radio" name="fulfillment" value="pickup" wire:model.live="fulfillment"
                                class="sr-only peer">
                            <div
                                class="py-2 text-center cursor-pointer transition-colors bg-gray-100 text-gray-700 peer-checked:bg-[#B68B62] peer-checked:text-white">
                                Pick Up
                            </div>
                        </label>
                    </div>

                    <div class="border border-[#B68B62] rounded-lg p-4 mb-6">
                        @if ($fulfillment === 'delivery')
                            <div class="flex justify-between items-center">
                                <div class="">
                                    <h3 class="font-semibold mb-2">
                                        Your Address
                                    </h3>
                                    <div class="text-sm md:text-md">{{ $address->name }} /
                                        {{ $address->address }}
                                    </div>
                                    <div class="mt-2 text-sm md:text-md">Phone : {{ $address->phone }} </div>
                                </div>
                                <flux:modal.trigger class="trigger" name="address">
                                    <button class="text-[#B68B62] text-sm font-medium hover:underline">Change
                                        Address</button>
                                </flux:modal.trigger>
                            </div>
                        @else
                            <div class="flex justify-between items-center">
                                <div class="">
                                    <h3 class="font-semibold mb-2">
                                        Our Outlet
                                    </h3>
                                    <div class="text-sm md:text-md">{{ $outlet->name }} /
                                        {{ $outlet->address }}
                                    </div>
                                    {{-- <div class="mt-2 text-sm md:text-md">Phone : {{ $address->phone }} </div> --}}
                                </div>
                                <flux:modal.trigger class="trigger" name="outlet">
                                    <button class="text-[#B68B62] text-sm font-medium hover:underline">Change
                                        Outlet</button>
                                </flux:modal.trigger>
                            </div>
                        @endif
                    </div>

                    <flux:modal name="address">
                        <div class="md:text-lg font-semibold">Choose Your Address</div>
                        @foreach ($addresses as $item)
                            <div wire:click='changeAddress({{ $item->id }})'
                                class=" cursor-pointer border mt-4 p-4  {{ $item->id == $address->id ? 'border-mine-200 bg-mine-200/5' : 'border-gray-200' }} rounded-lg w-full space-y-4">
                                <div class="">
                                    <div class="text-sm md:text-md font-semibold">{{ $item->name }} /
                                        {{ $item->phone }}</div>
                                    <div class="mt-2">{{ $item->address }}</div>
                                </div>
                                <a href="" class="underline underline-offset-2">Edit address</a>
                            </div>
                        @endforeach
                    </flux:modal>

                    <flux:modal name="outlet">
                        <div class="md:text-lg font-semibold">Choose Our Outlet</div>
                        @foreach ($outlets as $item)
                            <div wire:click='changeOutlet({{ $item->id }})'
                                class=" cursor-pointer border mt-4 p-4  {{ $item->id == $outlet->id ? 'border-mine-200 bg-mine-200/5' : 'border-gray-200' }} rounded-lg w-full space-y-4">
                                <div class="">
                                    <div class="text-sm md:text-md font-semibold">{{ $item->name }}</div>
                                    <div class="mt-2">{{ $item->address }}</div>
                                </div>
                                {{-- <a href="" class="underline underline-offset-2">Edit address</a> --}}
                            </div>
                        @endforeach
                    </flux:modal>

                    <div
                        class="grid grid-cols-6 font-semibold text-center text-sm border-b border-gray-300 pb-2 text-gray-800">
                        <div class="col-span-2">Product</div>
                        <div>Price</div>
                        <div>Qty</div>
                        <div>Total</div>
                        <div>Action</div>
                    </div>

                    @forelse ($carts as $key => $item)
                        <div class="grid grid-cols-6 items-center py-4 border-b border-gray-200 text-center">
                            <button class="flex items-center gap-2 col-span-2 text-left"
                                wire:click="openShowModal('{{ $item->product->jurnal_id }}')">
                                <div class="size-20 rounded bg-center bg-cover bg-no-repeat"
                                    style="background-image: url({{ asset("storage/{$item->product->image}") }})">
                                </div>
                                <div class="">
                                    <div class="font-semibold text-[#4B2E05]">{{ $item->product->name }}</div>
                                    <div class="text-xs md:text-sm">{{ $item->product->category->name }}</div>
                                </div>
                            </button>

                            <div class="text-gray-800 font-medium">Rp.
                                {{ number_format($item->product->price, 0, ',', '.') }}
                            </div>

                            <div class="flex items-center justify-center gap-2">
                                <button wire:click='minus({{ $item->id }})' icon="minus"
                                    class="bg-[#B68B62] px-1 text-white h-7 rounded-md text-sm font-bold cursor-pointer">
                                    <flux:icon icon="minus" class="w-5" />
                                </button>
                                <input wire:model.live='qty.{{ $key }}.qty'
                                    class="w-12 text-center! border rounded-md h-7" wire:change='change'
                                    min="{{ $item->product->moq }}" type="number"></input>
                                <button wire:click='plus({{ $item->id }})' icon="plus"
                                    class="bg-[#B68B62] px-1 text-white h-7 rounded-md text-sm font-bold cursor-pointer">
                                    <flux:icon icon="plus" class="w-5" />
                                </button>
                            </div>

                            <div class="flex items-center justify-center font-medium">
                                Rp. {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                            </div>

                            <div class="text-center">
                                <flux:button size="sm" wire:click='delete({{ $item->id }})' variant="danger"
                                    icon="trash"></flux:button>
                            </div>
                        </div>
                    @empty
                        <div class="flex justify-center items-center w-full h-80 font-semibold text-gray-500">
                            Looks like your cart is lonely. Add products to make it happy!
                        </div>
                    @endforelse
                </div>

                {{-- Right Section – Totals --}}
                <div class="bg-white rounded-2xl p-6 w-full lg:w-80 shadow h-fit">
                    <h3 class="text-xl font-semibold mb-4">Order Summary</h3>

                    <div class="flex justify-between text-gray-800 mb-3">
                        <div class="">SubTotal ({{ $carts->count() }} items)</div>
                        <div class="">Rp. {{ number_format($subtotal, 0, ',', '.') }}</div>
                    </div>

                    @if ($c ?? false)
                        <div class="flex justify-between text-gray-800 mb-3">
                            <div class="">Coupon</div>
                            <div class="">{{ $c->code }}</div>
                        </div>
                        <div class="flex justify-between text-gray-800 mb-3">
                            <div class="">Discount</div>
                            <div class="">Rp. {{ number_format($this->countDiscount(), 0, ',', '.') }}</div>
                        </div>
                    @endif

                    <hr class="border-gray-300 mb-3">

                    <div class="">
                        <flux:input wire:model.live='shipping_date' min="{{ $min }}" type="date"
                            label="Shipping Date">
                        </flux:input>
                    </div>
                    <div class="mt-2">
                        {{-- <div class="mb-2 font-medium text-gray-800">Order Note</div> --}}
                        <flux:textarea wire:model.live='note' label="Order Note"
                            placeholder="Add a note for your order..."
                            class="w-full rounded-md border border-gray-300 p-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-[#B68B62]">
                        </flux:textarea>
                    </div>

                    <div class="mb-3">
                        {{-- <div class="space-y-2">
                            <label class="flex items-center justify-between text-sm text-gray-700 cursor-pointer">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="shipping" checked class="accent-[#B68B62]" />
                                    GoJek
                                </div>
                                <span class="font-medium">Rp.24.000</span>
                            </label>

                            <label class="flex items-center justify-between text-sm text-gray-700 cursor-pointer">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="shipping" class="accent-[#B68B62]" />
                                    Grab
                                </div>
                                <span class="font-medium">Rp.25.000</span>
                            </label>
                        </div> --}}
                    </div>

                    @if ($cpn)
                        <div class="h-fit space-y-4 items-end rounded mb-2">
                            <div class="flex justify-between gap-4">

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
                        <button variant="primary" wire:click='pn({{ 1 }})'
                            class="w-full! mb-2 bg-[#29303A] hover:bg-[#4C535D] text-white py-2 font-medium rounded-md text-sm transition">
                            Have a coupon?</button>
                    @endif

                    <button wire:click='checkout'
                        class="bg-[#B68B62] hover:bg-[#9c724e] text-white w-full py-2 font-medium rounded-md text-sm transition">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </flux:container>

    @livewire('shop-show')
    @livewire('newsletter')
</div>
