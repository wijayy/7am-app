<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <div class="p-4 rounded bg-white dark:bg-neutral-700">


        <div class="flex items-center gap-4">
            <div class="w-fit">
                <flux:input wire:model.live='date' type="date"></flux:input>
            </div>
            <div class="">Summary</div>
        </div>
        {{-- <flux:input type="date" wire:model.live='date'></flux:input> --}}
        <div class="grid grid-cols-1 mt-4 md:grid-cols-2 gap-4">
            @forelse ($reservations as $key => $item)
                <div class="gap-2 flex flex-col rounded-lg p-4 py-2 border border-black dark:border-white">
                    <div class="">{{ $item->name }}</div>
                    <a target="_blank" href="https://wa.me/{{ $item->phone }}" class="text-sm">{{ $item->phone }}</a>
                    <flux:separator></flux:separator>
                    <div class="">Pax : {{ $item->pax }}</div>
                    <div class="">Date : {{ $item->date->format('d M Y H:i') }}</div>
                    <div class="">Outlet : {{ $item->outlet->name }} - {{ $item->section->name }}</div>
                    @if ($item->note)
                        <div class="">
                            <flux:separator text='Note'></flux:separator>
                            <div class="">{{ $item->note }}</div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="h-32 md:col-span-2 flex justify-center items-center text-gray-700 dark:text-gray-300">
                    You have not made any reservations yet.
                </div>
            @endforelse
        </div>
    </div>
</div>
