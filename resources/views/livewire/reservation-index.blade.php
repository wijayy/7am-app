<div class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <div class="p-4 rounded bg-white dark:bg-neutral-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div class="flex items-center gap-4">
                <flux:input wire:model.live="date" type="date" class="w-fit" />
                <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">Reservation Summary</div>
            </div>
        </div>

        <!-- Table -->
        @if ($reservations->count())
            <div class="overflow-x-auto">
                <table
                    class="min-w-full border-collapse border border-gray-200 dark:border-neutral-600 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-neutral-800">
                        <tr class="text-left text-gray-700 dark:text-gray-300 text-sm">
                            <th class="px-4 py-3 border-b border-gray-200 dark:border-neutral-600">#</th>
                            <th class="px-4 py-3 border-b border-gray-200 dark:border-neutral-600">Name</th>
                            <th class="px-4 py-3 border-b border-gray-200 dark:border-neutral-600">Phone</th>
                            <th class="px-4 py-3 border-b border-gray-200 dark:border-neutral-600">Pax</th>
                            <th class="px-4 py-3 border-b border-gray-200 dark:border-neutral-600">Date</th>
                            <th class="px-4 py-3 border-b border-gray-200 dark:border-neutral-600">Outlet</th>
                            <th class="px-4 py-3 border-b border-gray-200 dark:border-neutral-600">Section</th>
                            <th class="px-4 py-3 border-b border-gray-200 dark:border-neutral-600">Note</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm text-gray-800 dark:text-gray-100">
                        @foreach ($reservations as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-600 transition">
                                <td class="px-4 py-2 border-b border-gray-200 dark:border-neutral-600">
                                    {{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 dark:border-neutral-600">
                                    {{ $item->name }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 dark:border-neutral-600">
                                    <a target="_blank" href="https://wa.me/{{ $item->phone }}"
                                        class="text-blue-500 hover:underline">
                                        {{ $item->phone }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200 dark:border-neutral-600">
                                    {{ $item->pax }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 dark:border-neutral-600">
                                    {{ $item->date->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200 dark:border-neutral-600">
                                    {{ $item->outlet->name }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 dark:border-neutral-600">
                                    {{ $item->section->name }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 dark:border-neutral-600">
                                    {{ $item->note ?: '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $reservations->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <div class="h-32 flex justify-center items-center text-gray-700 dark:text-gray-300">
                You have not made any reservations yet.
            </div>
        @endif
    </div>
</div>
