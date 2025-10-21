@props(['text', 'description'])

<div class="md:h-[80vh] h-full w-full bg-center flex  justify-center items-center bg-cover bg-no-repeat" style="background-image: url({{ asset('assets/shop/banner.png') }})">
    {{-- <flux:container class=""> --}}
        <div class="md:mt-4 mt-12 w-[70%]">
            <div class="text-center md:text-4xl text-black font-medium">{{ $text }}</div>
            <div class="mt-4 md:text-xl text-center text-black ">{{ $description }}</div>
        </div>
    {{-- </flux:container> --}}
</div>
