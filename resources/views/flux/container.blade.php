@php
$classes = Flux::classes()
    ->add('mx-auto w-full [:where(&)]:max-w-7xl')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-container>
    {{ $slot }}
</div>
