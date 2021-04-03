<button {{ $attributes->merge(['type' => 'submit', 'class' => "inline-flex items-center border border-transparent rounded-md font-semibold text-xs text-red-500 tracking-widest hover:text-red-700 active:text-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"]) }}>
    {{ $slot }}
</button>
