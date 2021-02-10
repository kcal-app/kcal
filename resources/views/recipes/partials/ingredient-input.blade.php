<div>
    <x-inputs.input type="hidden" name="ingredients[original_key][]" :value="$original_key ?? null" />
    <div class="flex items-center space-x-2">
        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0 w-full">
            <div class="w-full">
                <x-ingredient-picker :default-id="$ingredient_id ?? null"
                                     :default-type="$ingredient_type ?? null"
                                     :default-name="$ingredient_name ?? null" />
            </div>
            <x-inputs.input name="ingredients[amount][]"
                            type="text"
                            size="5"
                            placeholder="Amount"
                            class="block"
                            :value="$amount ?? null" />
            <x-inputs.select name="ingredients[unit][]"
                             class="block"
                             :options="$ingredients_units"
                             :selectedValue="$unit ?? null">
                <option value="" selected>Unit</option>
            </x-inputs.select>
            <x-inputs.input name="ingredients[detail][]"
                            type="text"
                            class="block"
                            placeholder="Detail (diced, chopped, etc.)"
                            :value="$detail ?? null" />
        </div>
        <div class="flex-none">
            <x-inputs.icon-button type="button"
                                  color="red"
                                  x-on:click="$event.target.parentNode.parentNode.parentNode.remove(); (ingredients > 1 ? ingredients-- : null);">
                <svg class="h-8 w-8 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </x-inputs.icon-button>
        </div>
    </div>
    <hr class="my-4 md:hidden" x-show="ingredients > 0"/>
</div>
