<div class="space-y-4 mt-20">
    <flux:container>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 ">
            <div class="md:col-span-2 ">
                <div class="text-center text-xl font-semibold ">Members Info</div>

                <div class="grid grid-cols-4 gap-4 mt-4">
                    <div class="font-semibold">Name</div>
                    <div class="col-span-3">{{ $member->name }}</div>
                    <div class="font-semibold">Code</div>
                    <div class="col-span-3">{{ $member->code }}</div>
                    <div class="font-semibold">Phone</div>
                    <div class="col-span-3">{{ $member->phone }}</div>
                    <div class="font-semibold">Email</div>
                    <div class="col-span-3">{{ $member->email }}</div>
                    <div class="font-semibold">Birthday</div>
                    <div class="col-span-3">{{ $member->birthday->format('M d') }}</div>
                    <div class="font-semibold">Total Points</div>
                    <div class="col-span-3">{{ $member->total_point }}</div>
                    <div class="font-semibold">Active Points</div>
                    <div class="col-span-3">{{ $member->active_point }}</div>
                </div>
            </div>
            <div class="">
                <img class="rounded-lg" src="{{ asset("storage/{$member->card->card}") }}" alt="">
            </div>
        </div>
        <div class="flex mt-4 justify-center">
            <flux:radio.group wire:model.live='open' variant="segmented">
                <flux:radio value="transaction">Transaction History</flux:radio>
                <flux:radio value="redeem">Redeem History</flux:radio>
            </flux:radio.group>
        </div>

        @if ($open == 'transaction')
            <div class="mt-4 w-full min-h-56">
                <div class="flex gap-4 py-2">
                    <div class="w-10 text-center">#</div>
                    <div class="w-1/4">Date</div>
                    <div class="w-1/4 text-center">Outlet</div>
                    <div class="w-1/4 text-center">Amount</div>
                    <div class="w-1/4 text-center">Points rewared</div>
                </div>

                @forelse ($member->transaction as $item)
                    <div class="flex gap-4 py-1">
                        <div class="text-center w-10">{{ $loop->iteration }}</div>
                        <div class=" w-1/4">{{ $item->created_at->format('d M Y H:i') }}</div>
                        <div class="text-center w-1/4">{{ $item->outlet->name }}</div>
                        <div class="text-center w-1/4">Rp. {{ number_format($item->amount, 0, ',', '.') }}</div>
                        <div class="text-center w-1/4">{{ $item->poin }}</div>
                    </div>
                @empty
                    <div class="w-full h-32 flex justify-center items-center">
                        No Transaction History Found
                    </div>
                @endforelse
            </div>
        @else
            <div class="mt-4 w-full min-h-56 ">
                <div class="flex gap-4 py-2">
                    <div class="w-10 text-center">#</div>
                    <div class="w-1/4">Date</div>
                    <div class="w-1/4 text-center">Outlet</div>
                    <div class="w-1/4 text-center">Name</div>
                    <div class="w-1/4 text-center">Points redeemed</div>
                </div>

                @forelse ($member->redeem as $item)
                    <div class="flex gap-4 py-1">
                        <div class="text-center w-10">{{ $loop->iteration }}</div>
                        <div class=" w-1/4">{{ $item->created_at->format('d M Y H:i') }}</div>
                        <div class="text-center w-1/4">{{ $item->outlet->name }}</div>
                        <div class="text-center w-1/4">{{ $item->redeem_point->name }}</div>
                        <div class="text-center w-1/4">{{ $item->redeem_point->point }}</div>
                    </div>
                @empty
                    <div class="w-full h-32 flex justify-center items-center">
                        No Redeem History Found
                    </div>
                @endforelse
            </div>
        @endif
    </flux:container>
</div>
