@php
    $classes = Flux::classes()
        ->add('[:where(&)]:min-w-48 p-[.3125rem]')
        ->add('rounded-lg shadow-xs')
        ->add('border border-gray-200 dark:border-gray-600')
        ->add('bg-white dark:bg-gray-700')
        ->add('focus:outline-hidden');
@endphp

<ui-menu {{ $attributes->class($classes) }} popover="manual" data-flux-menu>
    {{ $slot }}
</ui-menu>
