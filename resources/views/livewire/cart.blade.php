<div>
    <flux:container class="mt-4">
        <div class="bg-[#E8E1D7] min-h-[55vh] dark:bg-gray-800 flex flex-col items-center">
            <div class="max-w-7xl w-full flex flex-col lg:flex-row gap-8">

                {{-- Left Section – Cart Items --}}
                <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 flex-1 shadow">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-black dark:text-white">My Cart</h2>
                    </div>

                    @if (session()->has('error'))
                        <div class="text-red-500 text-sm font-semibold">{{ session('error') }}</div>
                    @endif

                    <div class="">{{ date('H:i') }}</div>

                    <h4 class="font-medium text-gray-800 dark:text-neutral-300 mb-2">Shipping</h4>
                    <div class="flex border border-gray-300 rounded-lg overflow-hidden mb-3">
                        <label class="flex-1">
                            <input type="radio" name="fulfillment" value="delivery" wire:model.live="fulfillment"
                                class="sr-only peer" checked>
                            <div
                                class="py-2 text-center cursor-pointer transition-colors bg-gray-100 text-gray-700 peer-checked:bg-[#B68B62] dark:peer-checked:bg-gray-500 peer-checked:text-white">
                                Delivery
                            </div>
                        </label>

                        <label class="flex-1">
                            <input type="radio" name="fulfillment" value="pickup" wire:model.live="fulfillment"
                                class="sr-only peer">
                            <div
                                class="py-2 text-center cursor-pointer transition-colors bg-gray-100 text-gray-700 peer-checked:bg-[#B68B62] dark:peer-checked:bg-gray-500 peer-checked:text-white">
                                Pick Up
                            </div>
                        </label>
                    </div>

                    <div class="border border-[#B68B62] dark:border-white rounded-lg p-4 mb-6">
                        @if ($fulfillment === 'delivery')
                            <div class="flex justify-between items-center">
                                <div class="">
                                    <h3 class="font-semibold mb-2">
                                        Your Address
                                    </h3>
                                    <div class="text-sm md:text-md">{{ $address->name }} /
                                        {{ $address->phone }}
                                    </div>
                                    <div class="mt-2 text-sm md:text-md">Phone : {{ $address->address }} </div>
                                    <div class="text-xs md:text-sm">{{ $address->regency->name }} -
                                        {{ $address->district->name }} -
                                        {{ $address->village->name }}</div>
                                </div>
                                <flux:modal.trigger class="trigger" name="address">
                                    <button
                                        class="text-[#B68B62] dark:text-white text-sm font-medium hover:underline">Change
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
                                    <button
                                        class="text-[#B68B62] dark:text-white text-sm font-medium hover:underline">Change
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

                    @if (session()->has('info'))
                        <div class="mt-4 text-sm font-semibold text-sky-400">
                            {{ session('info') }}
                        </div>
                    @endif

                    <div
                        class="grid grid-cols-6 font-semibold text-center text-sm border-b mt-4 border-gray-300 pb-2 text-gray-800 dark:text-white">
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
                                    style="background-image: url({{ $item->image_url }})">
                                </div>
                                <div class="">
                                    <div class="font-semibold text-[#4B2E05] dark:text-white">
                                        {{ $item->product->name }}</div>
                                    <div class="text-xs md:text-sm dark:text-neutral-300">
                                        {{ $item->product->category->name }}</div>
                                </div>
                            </button>

                            <div class="text-gray-800 font-medium dark:text-neutral-300">Rp.
                                {{ number_format($item->product->price, 0, ',', '.') }}
                            </div>

                            <div class="flex items-center justify-center gap-2">
                                <button wire:click='minus({{ $item->id }})' icon="minus"
                                    class="bg-[#B68B62] dark:bg-gray-600 px-1 text-white h-7 rounded-md text-sm font-bold cursor-pointer">
                                    <flux:icon icon="minus" class="w-5" />
                                </button>
                                <input wire:model.live='qty.{{ $key }}.qty'
                                    class="w-12 text-center! border rounded-md h-7" wire:change='change'
                                    min="{{ $item->product->moq }}" type="number"></input>
                                <button wire:click='plus({{ $item->id }})' icon="plus"
                                    class="bg-[#B68B62] dark:bg-gray-600 px-1 text-white h-7 rounded-md text-sm font-bold cursor-pointer">
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
                <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full lg:w-80 shadow h-fit">
                    <h3 class="text-xl font-semibold mb-4">Order Summary</h3>

                    <div class="flex justify-between text-gray-800 mb-3">
                        <div class="dark:text-white">SubTotal ({{ $carts->count() }} items)</div>
                        <div class="dark:text-white">Rp. {{ number_format($subtotal, 0, ',', '.') }}</div>
                    </div>
                    <div class="flex justify-between text-gray-800 mb-3">
                        <div class="dark:text-white">Packaging Fee</div>
                        <div class="dark:text-white">Rp. {{ number_format($packaging_fee, 0, ',', '.') }}</div>
                    </div>

                    @if ($c ?? false)
                        <div class="flex justify-between text-gray-800 mb-3">
                            <div class="dark:text-white">Coupon</div>
                            <div class="dark:text-white">{{ $c->code }}</div>
                        </div>
                        <div class="flex justify-between text-gray-800 mb-3">
                            <div class="dark:text-white">Discount</div>
                            <div class="dark:text-white">Rp. {{ number_format($this->countDiscount(), 0, ',', '.') }}
                            </div>
                        </div>
                    @endif

                    <flux:separator></flux:separator>
                    <div class="flex justify-between  font-semibold  text-gray-800 mb-3">
                        <div class="dark:text-white">Total</div>
                        <div class="dark:text-white">Rp.
                            {{ number_format($subtotal + $packaging_fee - $this->countDiscount(), 0, ',', '.') }}
                        </div>
                    </div>

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
                                <div class="text-mine-200 dark:bg-white">Coupon applied</div>
                            @endif
                        </div>
                    @else
                        <button variant="primary" wire:click='pn({{ 1 }})'
                            class="w-full! mb-2 bg-[#29303A] dark:bg-gray-600 hover:bg-[#4C535D] text-white py-2 font-medium rounded-md text-sm transition">
                            Have a coupon?</button>
                    @endif

                    <flux:modal.trigger name="checkoutModal">
                        <button
                            class="bg-[#B68B62] hover:bg-[#9c724e] text-white w-full py-2 font-medium rounded-md text-sm transition">
                            Checkout
                        </button>
                    </flux:modal.trigger>

                    <x-action-message class="me-3 mt-4 text-red-500" on="error">
                        {{ __('Please Verified Your Business First') }}
                    </x-action-message>
                </div>
            </div>
        </div>
    </flux:container>

    <flux:modal name="checkoutModal">
        <div class="font-semibold">Checkout</div>
        <div class="">Are you sure you want to proceed with this checkout?
        </div>
        <div class="">

            You can still cancel the order within 5 minutes after checkout.</div>
        <div class="flex justify-end mt-4">
            <flux:button variant="primary" wire:click='checkout' class="me-2">
                Checkout
            </flux:button>
        </div>
    </flux:modal>

    @livewire('shop-show')
    @livewire('newsletter')
</div>
