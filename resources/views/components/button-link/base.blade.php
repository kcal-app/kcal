@php
    $classes = [
        'px-4',
        'py-2',
        'border',
        'border-transparent',
        'rounded-md',
        'font-semibold',
        'text-xs',
        'text-center',
        'uppercase',
        'tracking-widest',
        'focus:outline-none',
        'focus:ring',
        'disabled:opacity-25',
        'transition',
        'ease-in-out',
        'duration-150'
    ];
@endphp
<a {{ $attributes->merge(['class' => implode(' ', $classes)]) }}>
    {{ $slot }}
</a>
