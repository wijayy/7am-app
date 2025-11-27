<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="p-4 w-full max-w-lg bg-white border border-gray-200 rounded-lg shadow-md text-black">
        <div class="flex justify-center">
            <img class="w-1/2" src="{{ asset('assets/7am-transparent.png') }}" alt="">
        </div>
        <div class="">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
