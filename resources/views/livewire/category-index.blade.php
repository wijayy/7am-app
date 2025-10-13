<div class="">
    <flux:session>Categories</flux:session>

    <flux:container-sidebar>
        <div class="flex justify-end">
            <flux:button variant="primary" as href="{{ route('category.create') }}" icon="plus" size="sm">Add Category</flux:button>
        </div>
        <div class="grid grid-cols-12 font-semibold py-2 gap-4">
            <div class="">#</div>
            <div class="col-span-6">Category Name</div>
            <div class="col-span-3 text-center">Products Related</div>
            <div class="col-span-2 text-center">Action</div>
        </div>
        @foreach ($categories as $key => $item)
            <div class="grid grid-cols-12 py-1 gap-4">
                <div class="">{{ $key + 1 }}</div>
                <div class="col-span-6">{{ $item->name }}</div>
                <div class="col-span-3 text-center">{{ $item->products->count() }}</div>
                <div class="col-span-2 justify-center flex gap-2">
                    <flux:tooltip content="Edit Category">
                        <flux:button size="sm" as href="{{ route('category.edit', ['slug'=>$item->slug]) }}" icon="pencil-square" variant="primary" color="teal"></flux:button>
                    </flux:tooltip>
                    <flux:modal.trigger class="trigger" name="delete-{{ $key }}">
                        <flux:tooltip content="Delete Categories">
                            <flux:button size="sm" variant='danger' icon="trash"></flux:button>
                        </flux:tooltip>
                    </flux:modal.trigger>
                    <flux:modal name="delete-{{ $key }}">
                        <div class="font-semibold ">Delete {{ $item->name }}</div>
                        <div class="">This action will permanently remove {{ $item->name }}.</div>
                        <div class="flex mt-4 justify-end">
                            <flux:button variant="danger">Delete</flux:button>
                        </div>
                    </flux:modal>
                </div>

            </div>
        @endforeach
    </flux:container-sidebar>

</div>
