<flux:modal name="set-category-create" size="lg">
    <div class="font-semibold text-lg">{{ $title }}</div>
    <div class="mt-4">
        <form wire:submit.prevent="save">
            <flux:input 
                label="Set Category Name" 
                wire:model.defer="name" 
                required>
            </flux:input>

            <flux:select 
                label="Select Categories" 
                wire:model.defer="selectedCategories" 
                multiple 
                required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </flux:select>

            <div class="flex justify-end gap-2 mt-4">
                <flux:button variant="primary"
                    x-on:click="$dispatch('modal-close', { name: 'set-category-create' })">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Save
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>