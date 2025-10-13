@props(['text'])

<div class="md:h-64 h-44 w-full bg-center flex  justify-center items-center bg-cover bg-no-repeat" style="background-image: url({{ asset('assets/2nd.jpg') }})">
    {{-- <flux:container class=""> --}}
        <div class="md:mt-4 mt-12">
            <div class="text-center md:text-2xl  text-white">{{ $text }}</div>
            <div class="mt-4 md:text-lg text-center text-white ">Home > {{ $text }}</div>
        </div>
    {{-- </flux:container> --}}
</div>
