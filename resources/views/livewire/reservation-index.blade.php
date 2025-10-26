<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <div class="p-4 rounded bg-white dark:bg-neutral-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div class="flex items-center justify-between gap-4 w-full">
                <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">Reservation Summary</div>
                <div class="w-1/3">
                    <flux:input wire:model.live="date" type="date" class="w-full" />
                </div>
            </div>
        </div>

        <!-- Table -->
        @if ($reservations->count())
            <div class="overflow-x-auto">
                <div class="w-full border border-gray-200 dark:border-neutral-600 rounded-lg overflow-hidden">
                    {{-- Header --}}
                    <div
                        class="hidden text-center md:grid grid-cols-[60px_1fr_1fr_80px_150px_1fr_1fr_1fr] bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 text-sm font-semibold border-b border-gray-200 dark:border-neutral-600">
                        <div class="px-4 py-3">#</div>
                        <div class="px-4 py-3">Name</div>
                        <div class="px-4 py-3">Phone</div>
                        <div class="px-4 py-3">Pax</div>
                        <div class="px-4 py-3">Date</div>
                        <div class="px-4 py-3">Outlet</div>
                        <div class="px-4 py-3">Section</div>
                        <div class="px-4 py-3">Note</div>
                    </div>


                    <div class="w-full border border-gray-200 dark:border-neutral-600 overflow-hidden">
                        {{-- Rows --}}
                        <div
                            class="divide-y divide-gray-200 dark:divide-neutral-600 text-sm text-gray-800 dark:text-gray-100">
                            @foreach ($reservations as $index => $item)
                                <div
                                    class="grid grid-cols-1 md:grid-cols-[60px_1fr_1fr_80px_150px_1fr_1fr_1fr] items-start md:items-center hover:bg-gray-50 dark:hover:bg-neutral-600 transition">
                                    {{-- # --}}
                                    <div
                                        class="px-4 py-2 text-center md:border-0 border-b border-gray-100 dark:border-neutral-700">
                                        <div class="md:hidden text-gray-500 text-xs text-left">#</div>
                                        {{ $loop->iteration }}
                                    </div>

                                    {{-- Name --}}
                                    <div class="px-4 py-2 md:border-0 border-b border-gray-100 dark:border-neutral-700">
                                        <div class="md:hidden text-gray-500 text-xs">Name</div>
                                        {{ $item->name }}
                                    </div>

                                    {{-- Phone --}}
                                    <div class="px-4 py-2 md:border-0 border-b border-gray-100 dark:border-neutral-700">
                                        <div class="md:hidden text-gray-500 text-xs">Phone</div>
                                        <a target="_blank" href="https://wa.me/{{ $item->phone }}"
                                            class="text-blue-500 hover:underline">
                                            {{ $item->phone }}
                                        </a>
                                    </div>

                                    {{-- Pax --}}
                                    <div
                                        class="px-4 py-2 md:border-0 border-b border-gray-100 dark:border-neutral-700 text-center">
                                        <div class="md:hidden text-gray-500 text-xs">Pax</div>
                                        {{ $item->pax }}
                                    </div>

                                    {{-- Date --}}
                                    <div
                                        class="px-4 py-2 md:border-0 border-b border-gray-100 dark:border-neutral-700 whitespace-nowrap">
                                        <div class="md:hidden text-gray-500 text-xs">Date</div>
                                        {{ $item->date->format('d M Y H:i') }}
                                    </div>

                                    {{-- Outlet --}}
                                    <div class="px-4 py-2 md:border-0 border-b border-gray-100 dark:border-neutral-700">
                                        <div class="md:hidden text-gray-500 text-xs">Outlet</div>
                                        {{ $item->outlet->name }}
                                    </div>

                                    {{-- Section --}}
                                    <div class="px-4 py-2 md:border-0 border-b border-gray-100 dark:border-neutral-700">
                                        <div class="md:hidden text-gray-500 text-xs">Section</div>
                                        {{ $item->section->name }}
                                    </div>

                                    {{-- Note --}}
                                    <div class="px-4 py-2 md:border-0 border-b border-gray-100 dark:border-neutral-700">
                                        <div class="md:hidden text-gray-500 text-xs">Note</div>
                                        {{ $item->note ?: '-' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="h-32 flex justify-center items-center text-gray-700 dark:text-gray-300">
                You have not made any reservations yet.
            </div>
        @endif
    </div>
</div>
