<div class="">
    <flux:session>{{ $title }}</flux:session>

    <flux:container-sidebar>
        <form wire:submit='save' class="space-y-4">
            <flux:input wire:model.live='name' :label="'Category Name'"></flux:input>
            <flux:button type="submit" variant="primary">Save</flux:button>
        </form>
    </flux:container-sidebar>
</div>
