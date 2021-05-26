@php($key = $key ?? null)
<div x-data class="entry-item flex items-center space-x-2">
    <div class="flex flex-col space-y-4 w-full">
        <!-- Ingredient -->
        <div class="w-full">
            <x-inputs.label for="ingredients[id][]" value="Food or Recipe" class="md:hidden"/>
            <x-ingredient-picker :default-id="$id ?? null"
                                 :default-type="$type ?? null"
                                 :default-name="$name ?? null" />
        </div>
        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0 w-full">
            <!-- Date -->
            <div class="w-full">
                <x-inputs.label for="ingredients[date][]" value="Date" class="md:hidden"/>
                <x-inputs.input name="ingredients[date][]"
                                type="date"
                                class="block w-full"
                                :value="$date ?? $default_date->toDateString()"
                                :hasError="$errors->has('ingredients.date.' . $key)"
                                required />
            </div>

            <!-- Meal -->
            <div class="w-full">
                <x-inputs.label for="ingredients[meal][]" value="Meal" class="md:hidden"/>
                <x-inputs.select name="ingredients[meal][]"
                                 class="block w-full"
                                 :options="$meals->toArray()"
                                 :selectedValue="$meal ?? null"
                                 :hasError="$errors->has('ingredients.meal.' . $key)"
                                 required>
                    @if(is_null($key))<option value="">-- Meal --</option>@endif
                </x-inputs.select>
            </div>

            <!-- Amount -->
            <div class="w-full">
                <x-inputs.label for="ingredients[amount][]" value="Amount" class="md:hidden"/>
                <x-inputs.input name="ingredients[amount][]"
                                type="text"
                                size="5"
                                class="block w-full"
                                placeholder="Amount"
                                :value="$amount ?? null"
                                :hasError="$errors->has('ingredients.amount.' . $key)"
                                required />
            </div>

            <!-- Unit -->
            <div class="w-full">
                <x-inputs.label for="ingredients[unit][]" value="Unit" class="md:hidden"/>
                <x-inputs.select name="ingredients[unit][]"
                                 class="block w-full"
                                 :options="$units ?? []"
                                 :selectedValue="$unit ?? null"
                                 :hasError="$errors->has('ingredients.unit.' . $key)">
                    @if(is_null($key))<option value="">-- Unit --</option>@endif
                </x-inputs.select>
            </div>
        </div>
        <div class="w-full">
            <hr class="my-2"/>
        </div>
    </div>
    <div class="flex-none">
        <x-inputs.icon-red x-on:click="$event.target.parentNode.parentNode.remove();">
            <svg class="h-8 w-8 pointer-events-none m-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </x-inputs.icon-red>
    </div>
</div>

@once
    @push('scripts')
        <script type="text/javascript">
            /**
             * Sets default serving amount and unit on ingredient select.
             */
            window.addEventListener('ingredient-picked', (e) => {
                const entryItem = e.target.closest('.entry-item');
                const ingredient = e.detail.ingredient;
                let servingSize, servingUnit

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

                // Always set recipes to a default of 1 serving.
                if (ingredient.type === 'App\\Models\\Recipe') {
                    servingSize = 1;
                    servingUnit = 'serving';
                } else if (ingredient.type === 'App\\Models\\Food') {
                    servingUnit = ingredient.serving_unit ?? 'serving'

                    // Any food with a unit of "serving" (or no unit) defaults
                    // to 1 serving. This accounts for food with configurations
                    // like "2 scoops" using a custom serving unit.
                    if (servingUnit === 'serving') {
                        servingSize = 1;
                    } else {
                        servingSize = ingredient.serving_size_formatted
                    }
                }
                entryItem.querySelector(':scope input[name="ingredients[amount][]"]').value = servingSize;
                entryItem.querySelector(':scope select[name="ingredients[unit][]"]').value = servingUnit;
            });
        </script>
    @endpush
@endonce
