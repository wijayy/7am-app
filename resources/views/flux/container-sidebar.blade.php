@php
    $classes = Flux::classes('bg-white dark:bg-neutral-700 overflow-x-auto rounded p-4');
@endphp

<div {{ $attributes->class($classes) }}>{{ $slot }}</div>
