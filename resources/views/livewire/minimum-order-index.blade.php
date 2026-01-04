<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>
    <flux:container-sidebar>
        <div class="flex gap-4 min-w-2xl py-2 font-semibold">
            <div class="w-10">#</div>
            <div class="w-1/5 text-center">Regency</div>
            <div class="w-1/5 text-center">District</div>
            <div class="w-1/5 text-center">Village</div>
            <div class="w-1/5 text-center">Minimum Order</div>
            <div class="w-1/5 text-center">Action</div>
        </div>
        @foreach ($minimumOrders as $key => $item)
            <div class="flex gap-4 min-w-2xl py-1">
                <div class="w-10">{{ $key + 1 }}</div>
                <div class="w-1/5 text-center">{{ $item->village->district->regency->name }}</div>
                <div class="w-1/5 text-center">{{ $item->village->district->name }}</div>
                <div class="w-1/5 text-center">{{ $item->village->name }}</div>
                <div class="w-1/5 text-center">Rp{{ number_format($item->minimum, 0, '.', ',') }}</div>
                <div class="w-1/5 text-center flex justify-center gap-2">
                    <flux:button icon='pencil-square'
                        wire:click="$dispatch('openEditMinimumOrderModal', { id:
                        {{ $item->id }} }).global"
                        variant="primary" size="sm" color="amber">
                    </flux:button>
                </div>
            </div>
        @endforeach
    </flux:container-sidebar>

    @livewire('minimum-order-create')
</div>
