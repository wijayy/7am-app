<flux:modal name="set-category-create" size="lg">
    <div class="font-semibold text-lg">{{ $title }}</div>
    <div class="mt-4">
        <form wire:submit.prevent="save">
            <flux:input label="Set Category Name" wire:model.defer="name" required>
            </flux:input>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                @foreach ($categories as $item)
                    <div class="p-2 flex border gap-2 items-center rounded-lg cursor-pointer
                {{ in_array($item->id, $selectedCategories) ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}"
                        wire:click="toggleCategory({{ $item->id }})">
                        <div class="size-10 bg-center bg-no-repeat bg-cover rounded"
                            style="background-image: url({{ $item->image_url }});">
                        </div>
                        <div>{{ $item->name }}</div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <flux:button variant="primary" x-on:click="$dispatch('modal-close', { name: 'set-category-create' })">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Save
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>
