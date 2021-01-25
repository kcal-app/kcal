<div x-data x-init="setDefaultsFromPrevious($el);" class="grid grid-cols-12 gap-4 items-center mt-2">
    <!-- Date -->
    <div class="col-span-2">
        <x-inputs.input class="block w-full"
                        type="date"
                        name="ingredients[date][]"
                        :value="$date ?? $default_date->toDateString()"
                        required />
    </div>

    <!-- Meal -->
    <div class="col-span-2">
        <x-inputs.select name="ingredients[meal][]"
                         class="block w-full"
                         :options="$meals"
                         :selectedValue="$meal ?? null"
                         required>
            <option value=""></option>
        </x-inputs.select>
    </div>

    <!-- Amount -->
    <div>
        <x-inputs.input type="text"
                        name="ingredients[amount][]"
                        class="block w-full"
                        :value="$amount ?? null" />
    </div>

    <!-- Unit -->
    <div class="col-span-2">
        <x-inputs.select name="ingredients[unit][]"
                         class="block w-full"
                         :options="$units"
                         :selectedValue="$unit ?? null">
            <option value=""></option>
        </x-inputs.select>
    </div>

    <!-- Ingredient -->
    <div class="col-span-4">
        <x-ingredient-picker :default-id="$id ?? null"
                             :default-type="$type ?? null"
                             :default-name="$name ?? null" />
    </div>

    <x-inputs.icon-button type="button" color="red" x-on:click="$parent.ingredients--; $event.target.parentNode.remove();">
        <svg class="h-8 w-8 pointer-events-none m-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
    </x-inputs.icon-button>
</div>

@once
    @push('scripts')
        <script type="text/javascript">
            let setDefaultsFromPrevious = ($el) => {
                let currentDateEl = $el.querySelector('input[name="ingredients[date][]"]');
                let currentMealEl = $el.querySelector('select[name="ingredients[meal][]"]');
                let previousEl = $el.previousElementSibling;
                let previousDateEl = previousEl.querySelector('input[name="ingredients[date][]"]');
                let previousMealEl = previousEl.querySelector('select[name="ingredients[meal][]"]');
                if (currentDateEl && currentMealEl && previousDateEl && previousMealEl) {
                    currentDateEl.value = previousDateEl.value;
                    currentMealEl.value = previousMealEl.value;
                }
            }
        </script>
    @endpush
@endonce
