@php
    $classes = Flux::classes('bg-white dark:bg-gray-700 h-full flex flex-col overflow-x-auto rounded p-4');
@endphp

<div {{ $attributes->class($classes) }}>{{ $slot }}</div>
