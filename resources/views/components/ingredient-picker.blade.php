<div x-data="{ searching: false, results: [] }">
    <div>
        <div>
            <x-inputs.input type="hidden"
                            name="ingredients[{{ $index }}]"
                            value="{{ $defaultId ?? '' }}"
                            x-ref="ingredients{{ $index }}"/>
            <x-inputs.input type="text"
                            name="ingredients_name[{{ $index }}]"
                            value="{{ $defaultName ?? '' }}"
                            placeholder="Search..."
                            autocomplete="off"
                            x-on:input.debounce.400ms="if ($event.target.value != '') {
                                fetch('{{ route('ingredient-picker.search') }}')
                                  .then(response => response.json())
                                  .then(data => { results = data; searching = true; }); }"
                            x-on:focusout.debounce.200ms="searching = false;"
                            x-ref="ingredients_name{{ $index }}" />
        </div>
        <div x-show="searching" x-cloak>
            <div class="absolute border-2 border-gray-500 border-b-0 bg-white"
                 x-on:click="selected = $event.target; if (selected.dataset.id) { $refs.ingredients_name{{ $index }}.value = selected.dataset.value; $refs.ingredients{{ $index }}.value = selected.dataset.id; searching = false; }">
                <template x-for="result in results" :key="result.id">
                    <div class="p-1 border-b-2 border-gray-500 hover:bg-yellow-300 cursor-pointer"
                         x-bind:data-id="result.id"
                         x-bind:data-value="result.name">
                        <div class="pointer-events-none">
                            <div x-text="result.name"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
