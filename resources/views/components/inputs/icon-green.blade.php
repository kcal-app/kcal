<button {{ $attributes->merge(['type' => 'submit', 'class' => "inline-flex items-center border border-transparent rounded-md font-semibold text-xs text-emerald-500 tracking-widest hover:text-emerald-700 active:text-emerald-900 focus:outline-none focus:border-emerald-900 focus:ring ring-emerald-300 disabled:opacity-25 transition ease-in-out duration-150"]) }}>
    {{ $slot }}
</button>
