@php($key = $key ?? null)
@error("ingredients.amount.{$key}")
    @php($amount_error = 'border-red-600')
@enderror
@error("ingredients.unit.{$key}")
    @php($unit_error = 'border-red-600')
@enderror

<div class="ingredient draggable">
    <x-inputs.input type="hidden" name="ingredients[key][]" :value="$key" />
    <x-inputs.input type="hidden" name="ingredients[weight][]" :value="$weight ?? null" />
    <div class="flex items-center space-x-2">
        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0 w-full">
            <div class="draggable-handle self-center text-gray-500 bg-gray-100 w-full md:w-auto p-2 cursor-move">
                <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="w-full">
                <x-ingredient-picker :default-id="$ingredient_id ?? null"
                                     :default-type="$ingredient_type ?? null"
                                     :default-name="$ingredient_name ?? null"
                                     :has-error="(isset($amount) || isset($unit)) && empty($ingredient_id)"/>
            </div>
            <x-inputs.input name="ingredients[amount][]"
                            type="text"
                            size="5"
                            placeholder="Amount"
                            class="block {{ $amount_error ?? null }}"
                            :value="$amount ?? null" />
            <x-inputs.select name="ingredients[unit][]"
                             class="block {{ $unit_error ?? null }}"
                             :options="$units_supported ?? []"
                             :selectedValue="$unit ?? null">
                <option value="" selected>Unit</option>
            </x-inputs.select>
            <x-inputs.input name="ingredients[detail][]"
                            type="text"
                            class="block"
                            autocapitalize="none"
                            placeholder="Detail (diced, chopped, etc.)"
                            :value="$detail ?? null" />
        </div>
        <div class="flex-none">
            <x-inputs.icon-red x-on:click="$event.target.parentNode.parentNode.parentNode.remove();">
                <svg class="h-8 w-8 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </x-inputs.icon-red>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script type="text/javascript">
            /**
             * Sets default serving amount and unit on ingredient select.
             */
            window.addEventListener('ingredient-picked', (e) => {
                const entryItem = e.target.closest('.ingredient');
                const ingredient = e.detail.ingredient;
                // Restrict unit select list values to supported units.
                const unitsSelectList = entryItem.querySelector(':scope select[name="ingredients[unit][]"]');
                for (const [key, option] in unitsSelectList.options) {
                    unitsSelectList.remove(key);
                }
                for (const key in ingredient.units_supported) {
                    const unit = ingredient.units_supported[key];
                    const option = document.createElement('option');
                    option.value = unit.value;
                    option.text = unit.label;
                    unitsSelectList.add(option);
                }
            });
        </script>
    @endpush
@endonce
