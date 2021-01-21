@props(['color' => 'gray'])

<button {{ $attributes->merge(['type' => 'submit', 'class' => "inline-flex items-center border border-transparent rounded-md font-semibold text-xs text-{$color}-500 tracking-widest hover:text-{$color}-700 active:text-{$color}-900 focus:outline-none focus:border-{$color}-900 focus:ring ring-{$color}-300 disabled:opacity-25 transition ease-in-out duration-150"]) }}>
    {{ $slot }}
</button>
