    <flux:container class="mt-20 pb-4 w-full">
        @include('partials.settings-heading')

        <x-settings.layout :heading="__('Business Profile')" class="space-y-4" :subheading="__('This information is required for your business to place orders and make payments.')">
            @if (session()->has('success'))
                <div class="text-green-500 font-semibold text-sm">{{ session('success') }}</div>
            @endif
            <form wire:submit='save'>
                <flux:separator text="Bussiness Identity">
                </flux:separator>
                <div class="space-y-4">

                    <flux:input :readonly="in_array(Auth::user()->business, ['requested', 'accepted'])"
                        label="Bussiness Name/Outlet Name" required wire:model.live='name'></flux:input>
                    <flux:input only_number :readonly="in_array(Auth::user()->business, ['requested', 'accepted'])"
                        label="Bussiness Registration Number" placeholder="NPWP, Tax ID, VAT, or Government-issued number"
                        required wire:model.live='npwp'>
                    </flux:input>
                    <flux:input :readonly="in_array(Auth::user()->business, ['requested', 'accepted'])" label="Address"
                        required wire:model.live='address'></flux:input>
                </div>

                <flux:separator text="Bank Information">
                </flux:separator>
                <div class="space-y-4">
                    <flux:input :readonly="in_array(Auth::user()->business, ['requested', 'accepted'])"
                        label="Bank Name" required wire:model.live='bank'></flux:input>
                    <flux:input only_number :readonly="in_array(Auth::user()->business, ['requested', 'accepted'])"
                        label="Account Number" required wire:model.live='account_number'></flux:input>
                    <flux:input :readonly="in_array(Auth::user()->business, ['requested', 'accepted'])"
                        label="Account Name" required wire:model.live='account_name'></flux:input>
                </div>

                <flux:separator text="Representative">
                </flux:separator>
                <div class="space-y-4">
                    <div class="w-full sm:w-80">
                        <flux:input aspect="16/10" type="file" label="Representative ID Card"
                            preview="{{ $preview }}" required wire:model.live='id_card'
                            :readonly="in_array(Auth::user()->business, ['requested', 'accepted'])">
                        </flux:input>
                    </div>
                    <flux:input :readonly="in_array(Auth::user()->business, ['requested', 'accepted'])"
                        label="Representative Name" required wire:model.live='representative'></flux:input>
                    <flux:input :readonly="in_array(Auth::user()->business, ['requested', 'accepted'])"
                        label="Representative Phone Number" only_number required wire:model.live='phone'></flux:input>
                </div>
                @if (!in_array(Auth::user()->business, ['requested', 'accepted']))
                    <div class="mt-4">
                        <flux:button type="submit" variant="primary">Submit</flux:button>
                    </div>
                @endif
            </form>
        </x-settings.layout>
    </flux:container>
