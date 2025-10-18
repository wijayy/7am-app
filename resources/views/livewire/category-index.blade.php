<div class="space-y-4">
    <flux:session>Categories</flux:session>

    <flux:container-sidebar>
        <div class="grid grid-cols-12 font-semibold py-2 gap-4">
            <div class="">#</div>
            <div class="col-span-6">Category Name</div>
        </div>
        @foreach ($categories as $key => $item)
            <div class="grid grid-cols-12 py-1 gap-4">
                <div class="">{{ $key + 1 }}</div>
                <div class="col-span-6">{{ $item['name'] }}</div>
            </div>
        @endforeach
    </flux:container-sidebar>
</div>
