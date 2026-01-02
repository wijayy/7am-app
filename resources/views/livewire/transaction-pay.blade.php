<div class="space-y-4">
    <flux:modal name="pay-transaction">
        <form wire:submit='save' class="mt-4 space-y-4 md:min-w-lg">
            <div class="">
                Pay Transaction
            </div>
            @if (session()->has('error'))
                <div class="text-rose-400 text-sm">{{ session('error') }}</div>
            @endif

            <flux:separator text="Transaction Info"></flux:separator>
            <div class="flex gap-4 text-start">
                <div class="w-1/3">Transaction Number</div>
                <div class="w-2/3">: {{ $transaction?->transaction_number }}</div>
            </div>
            <div class="flex gap-4 text-start">
                <div class="w-1/3">Total Amount</div>
                <div class="w-2/3">: {{ number_format($transaction?->total, 0, ',', '.') }}</div>
            </div>

            <flux:separator text="Payment Info"></flux:separator>
            <div class="flex flex-col gap-4">
                <flux:input label="Amount" type="number" wire:model.live="amount" />
                <flux:input label="Payment Type" type="text" wire:model.live="payment_type" />
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <flux:button wire:click="$emit('close-modal', 'pay-transaction')" variant="danger">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Pay Now
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
