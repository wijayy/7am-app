<form wire:submit='save' class="space-y-4">
    <flux:session>{{ $title }}</flux:session>

    <flux:container-sidebar>
        <div class="w-full max-w-64">
            <flux:input type="file" wire:model.live='image' preview="{{ $preview }}" :label="__('Product Image')"></flux:input>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model.live='name' :label="'Product Name'"></flux:input>
            <flux:select wire:model.live='category_id' :label="'Category'">
                @foreach ($categories as $item)
                <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input wire:model.live='price' type="number" min="1" :label="'Product Price'"></flux:input>
            <flux:input wire:model.live='moq' type="number" min="1" :label="'MOQ'"></flux:input>
            <div class=" md:col-span-2">
                <flux:input wire:model.live='description' :label="'Description'"></flux:input>
            </div>
            <flux:select wire:model.live='freshness' :label="'Freshness'">
                <flux:select.option value="fresh baked">Fresh Baked</flux:select.option>
                <flux:select.option value="last">Last 1-2 Days</flux:select.option>
                <flux:select.option value="frozen">Frozen</flux:select.option>
            </flux:select>
            <flux:select wire:model.live='status' :label="'Status'">
                <flux:select.option value="active">Active</flux:select.option>
                <flux:select.option value="inactive">Inactive</flux:select.option>
            </flux:select>
        </div>
        <div class="mt-4">
            <flux:label>Ingredients</flux:label>
        </div>
        <flux:button type="submit">Save</flux:button>
    </flux:container-sidebar>
</form>
