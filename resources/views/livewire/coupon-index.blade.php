<div class="space-y-4">
    <flux:session>All Coupon</flux:session>

    <flux:container-sidebar>
        <div class="flex justify-end">
            <flux:button icon="plus" size="sm" variant="primary" as href="{{ route('coupon.create') }}">Add Coupon
            </flux:button>
        </div>
        <div class="grid grid-cols-1 mt-4 sm:grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($coupons as $item)
                <div
                    class="rounded border text-xs p-2 {{ $item->is_active() ? 'border-mine-200 bg-mine-200/20' : 'border-neutral-200' }}">
                    <div class="font-semibold text-sm">{{ $item->code }}</div>
                    @if ($item->type == 'fixed')
                        <div class="">Rp. {{ number_format($item->amount, 0, ',', '.') }}</div>
                    @else
                        <div class="">
                            {{ number_format($item->amount, 0, ',', '.') }}%{{ $item->maximum > 0 ? ', up to Rp. ' . number_format($item->maximum, 0, ',', '.') : '' }}
                        </div>
                    @endif

                    <div class="">Limit: {{ $item->limit }}</div>
                    <div class="">Usage: {{ $item->usage->count() }}</div>
                    <div class="{{ $item->is_active() ? 'text-mine-200' : 'text-mine-300' }}">Status:
                        {{ $item->is_active() ? 'Active' : 'Inactive' }}</div>
                    @if ($item->is_active())
                        <div class="">Valid Until : {{ $item->end_time->diffForHumans() }}</div>
                    @endif

                    <div class="mt-4 flex gap-2 justify-center">
                        <flux:button icon="pencil-square" variant="primary" color="sky" as
                            href="{{ route('coupon.edit', ['slug' => $item->slug]) }}" size="sm"></flux:button>
                        <flux:button icon="trash" variant="danger" size="sm"></flux:button>
                    </div>
                </div>
            @endforeach
        </div>
    </flux:container-sidebar>
</div>
