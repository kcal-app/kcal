@props(['disabled' => false, 'hasError' => false])

@php
    $classes = [
        'rounded-md',
        'shadow-sm',
        'border-gray-300',
        'focus:border-indigo-300',
        'focus:ring',
        'focus:ring-indigo-200',
        'focus:ring-opacity-50',
    ];
    if ($hasError) {
        $classes[] = 'border-red-600';
    }
@endphp

<select
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => implode(' ', $classes)]) !!}>
    {{ $slot }}
    <x-inputs.select-options :options="$options" :selectedValue="$selectedValue" />
</select>
