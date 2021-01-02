@foreach ($options as $option)
    @if(is_iterable($option['value']))
        <optgroup label="{{ $option['label'] }}">
            <x-inputs.select-options :options="$option['value']"
                                     :selectedValue="$selectedValue" />
        </optgroup>
    @else
        <option value="{{ $option['value'] }}"
                @if ($option['value'] == $selectedValue) selected @endif>
            {{ $option['label'] }}
        </option>
    @endif
@endforeach
