<select {{ $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) }}>
    {{ $slot }}
    @foreach ($options as $option)
        <option value="{{ $option['value'] }}"
                @if ($option['value'] === $selectedValue) selected @endif>
            {{ $option['label'] }}
        </option>
    @endforeach
</select>
