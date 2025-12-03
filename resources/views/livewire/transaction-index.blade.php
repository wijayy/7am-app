<div class="space-y-4">
    <flux:session>Transactions</flux:session>

    <flux:container-sidebar>
        <div class="flex gap-4 items-center ">
            <flux:input class="w-fit!" type="date" wire:change='updateDate' wire:model.live='date'></flux:input>
            <div class="">summary</div>
            <flux:spacer></flux:spacer>
            <flux:button wire:click='export'>Export</flux:button>
        </div>
        <div class="grid-cols-1 mt-4 grid gap-4">
            @foreach ($transactions as $item)
                <div class="bg-gray-200 dark:bg-gray-600 rounded p-4 gap-4" x-data={open:false}>
                    <div class="">
                        <div class="sr-only">Shipping Information</div>
                        <div class="">
                            <div class="text-sm md:text-md font-semibold">{{ $item->shipping->name }} /
                                {{ $item->shipping->phone }}</div>
                            <div class="mt-2 text-xs md:text-sm">{{ $item->shipping->address }}</div>
                        </div>
                    </div>
                    <flux:separator text="Product"></flux:separator>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($item->items as $key => $itm)
                            <div class="grid grid-cols-4 items-center" x-show="open||{{ $key }} == 0" x-cloak
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-90">
                                <div class="flex items-center gap-2">
                                    <div class="size-20 rounded bg-center bg-cover bg-no-repeat"
                                        style="background-image: url({{ $itm->product->image_url }})">
                                    </div>
                                    <div class="">
                                        <div class="font-semibold">{{ $itm->product->name }}</div>
                                        <div class="text-xs md:text-sm">{{ $itm->product->category->name }}</div>
                                    </div>
                                </div>
                                <div class="text-center">Rp.
                                    {{ number_format($itm->price, 0, ',', '.') }}
                                </div>
                                <div class="text-center">
                                    {{ $itm->qty }} Pcs
                                </div>
                                <div class="text-center">Rp.
                                    {{ number_format($itm->subtotal, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <flux:button icon="chevron-down" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            x-on:click="open=true" x-show="!open" class="w-full" variant="primary"></flux:button>
                        <flux:button icon="chevron-up" x-cloak x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            x-on:click="open=false" x-show="open" class="w-full" variant="primary"></flux:button>
                    </div>
                    <flux:separator text="Shipping Info"></flux:separator>
                    <div class="mt-2 text-xs md:text-sm">
                        <div class="">Shipping Date: {{ $item->shipping_date->format('Y-m-d') }}</div>
                        <div class="">Order Status: {{ $item->status }}</div>
                    </div>
                    <flux:separator text="Order summary"></flux:separator>
                    <div class="w-full rounded-sm mt-2 text-xs md:text-sm space-y-2 ">
                        <div class="flex justify-between items-center">
                            <div class="">Subtotal ({{ $item->items->count() }} items)</div>
                            <div class="">Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="">Packaging </div>
                            <div class="">Rp. {{ number_format($item->packaging_fee, 0, ',', '.') }}</div>
                        </div>
                        @if ($item->coupon)
                            <div class="flex justify-between items-center">
                                <div class="">Coupon</div>
                                <div class="">{{ $item->usage->coupon->code }}</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="">Discount</div>
                                <div class="">Rp. {{ number_format($item->discount, 0, ',', '.') }}</div>
                            </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <div class="">Payment Status</div>
                            <div class="">
                                @if ($item->payment ?? false)
                                    Paid
                                @else
                                    Unpaid
                                @endif
                            </div>
                        </div>

                        @if ($item->payment ?? false)
                            <div class="flex justify-between items-center">
                                <div class="">Payment Method</div>
                                <div class="capitalize">{{ $item->payment->payment_type }}</div>
                            </div>
                        @endif
                        <flux:separator></flux:separator>
                        <div class="flex justify-between items-center">
                            <div class="">Total</div>
                            <div class="">Rp. {{ number_format($item->total, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @if ($item->mekari_sync_status == 'pending')
                        <div class="flex justify-center ">
                            <flux:button wire:click='importInvoice({{ $item->id }})'>Import Invoice to Jurnal
                            </flux:button>
                        </div>
                    @endif
                    @if ($item->mekari_sync_status == 'synced' && $item->payment && $item->payment->mekari_sync_status == 'pending')
                        <div class="flex justify-center ">
                            <flux:button wire:click='importPayment({{ $item->id }})'>Import Payment to Jurnal
                            </flux:button>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    </flux:container-sidebar>
</div>
