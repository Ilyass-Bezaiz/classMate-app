@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center py-2 px-5 text-[#5A6ACF] rounded-[30px] bg-[#707FDD] bg-opacity-10 group'
            : 'flex items-center py-2 px-5 text-gray-900 rounded-[30px] dark:text-white hover:bg-[#707FDD] hover:bg-opacity-10 dark:hover:bg-gray-700 group';
@endphp

<a wire:navigate {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
