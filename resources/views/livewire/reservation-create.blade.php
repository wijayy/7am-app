<div class="mt-20">
    <flux:container>
        <div class="text-xl font-semibold text-center">{{ $title }}</div>

        <form wire:submit='save' class="w-full h-fit rounded-lg space-y-4 mt-4 p-4">
            <div class="overflow-x-auto">
                {{-- <flux:label>Choose your outlet</flux:label> --}}
                <flux:radio.group class="grid! grid-cols-3!" label="Choose your outlet" wire:model.live='outlet_id'
                    variant="segmented">
                    @foreach ($outlets as $item)
                        <flux:radio :value="$item->id">
                            <div class=" w-full space-y-4 py-4">
                                <div class="bg-center bg-no-repeat rounded-lg bg-cover w-full aspect-3/4"
                                    style="background-image: url({{ asset('storage/' . $item->image) }})"></div>
                                <div class="font-semibold text-xs text-wrap md:text-base text-center">
                                    {{ $item->name }}</div>
                            </div>
                        </flux:radio>
                    @endforeach
                </flux:radio.group>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 items-start gap-4">
                <flux:input wire:model.live='name' label="Input your Name" autocorrect="name"></flux:input>
                <flux:input wire:model.live='phone' label="Whatsapp Number" autocorrect="phone"></flux:input>
                <flux:input wire:model.live='pax' type="number" min="1" label="Pax" autocorrect="pax">
                </flux:input>
                <flux:input wire:model.live='date' type="date" label="Reservation Date" autocorrect="date"
                    min="{{ date('Y-m-d') }}"></flux:input>
                <flux:input wire:model.live='time' type="time" label="Reservation Time" autocorrect="date"
                    min="{{ $outlet?->start_time->format('H:i') ?? null }}" max="{{ $outlet?->end_time->format('H:i') ?? null }}">
                </flux:input>

                <flux:select wire:model.live='section_id' label="Choose Section" :disabled="$sections == null">
                    <flux:select.option value="" selected>Choose Section</flux:select.option>
                    @if ($sections)
                        @foreach ($sections as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}
                            </option>
                        @endforeach
                    @endif
                </flux:select>
            </div>
            <flux:textarea wire:model.live='note' label="Write a note (if any)"></flux:textarea>

            @unless ($errors->any())
                <flux:button variant="primary" type="submit">Submit</flux:button>
            @endunless
        </form>
    </flux:container>
</div>
