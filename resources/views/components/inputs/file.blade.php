@props(['disabled' => false])

<input type="file"
       {{ $disabled ? 'disabled' : '' }}
       {!! $attributes->merge(['class' => 'focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
