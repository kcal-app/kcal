<div x-data="{ searching: false, results: [] }">
    <div>
        <div>
            <x-inputs.input type="hidden"
                            name="ingredients[]"
                            value="{{ $defaultId ?? '' }}"
                            x-ref="ingredients"/>
            <x-inputs.input type="text"
                            name="ingredients_name[]"
                            value="{{ $defaultName ?? '' }}"
                            placeholder="Search..."
                            autocomplete="off"
                            x-on:input.debounce.400ms="if ($event.target.value != '') {
                                fetch('{{ route('ingredient-picker.search') }}?term=' + $event.target.value)
                                  .then(response => response.json())
                                  .then(data => { results = data; searching = true; }); }"
                            x-on:focusout.debounce.200ms="searching = false;"
                            x-ref="ingredients_name" />
        </div>
        <div x-show="searching" x-cloak>
            <div class="absolute border-2 border-gray-500 border-b-0 bg-white"
                 x-on:click="selected = $event.target; if (selected.dataset.id) { $refs.ingredients_name.value = selected.dataset.value; $refs.ingredients.value = selected.dataset.id; searching = false; }">
                <template x-for="result in results" :key="result.id">
                    <div class="p-1 border-b-2 border-gray-500 hover:bg-yellow-300 cursor-pointer"
                         x-bind:data-id="result.id"
                         x-bind:data-value="result.name">
                        <div class="pointer-events-none">
                            <div x-text="result.name"></div>
                            <div class="text-sm text-gray-600" x-text="result.brand" x-show="result.brand"></div>
                            <div class="text-sm">
                                Serving size <span x-text="result.serving_size_formatted"></span>
                                <span x-text="result.serving_unit"></span>
                                (<span x-text="result.serving_weight"></span>g)
                            </div>
                        </div>
                    </div>
                </template>
                <div class="p-1 border-b-2 border-gray-500" x-cloak x-show="searching && results.length == 0">
                    No results found.
                </div>
            </div>
        </div>
    </div>
</div>
