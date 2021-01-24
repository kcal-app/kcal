<div x-data="picker()">
    <div>
        <div>
            <x-inputs.input type="hidden"
                            name="ingredients[id][]"
                            value="{{ $defaultId ?? '' }}"
                            x-ref="ingredients"/>
            <x-inputs.input type="hidden"
                            name="ingredients[type][]"
                            value="{{ $defaultType ?? '' }}"
                            x-ref="ingredients_type"/>
            <x-inputs.input type="text"
                            name="ingredients[name][]"
                            value="{{ $defaultName ?? '' }}"
                            placeholder="Search..."
                            autocomplete="off"
                            class="w-full"
                            x-ref="ingredients_name"
                            x-spread="search" />
        </div>
        <div x-show="searching" x-cloak>
            <div class="absolute border-2 border-gray-500 border-b-0 bg-white"
                 x-spread="ingredient">
                <template x-for="result in results" :key="result.id">
                    <div class="p-1 border-b-2 border-gray-500 hover:bg-yellow-300 cursor-pointer"
                         x-bind:data-id="result.id"
                         x-bind:data-type="result.type"
                         x-bind:data-name="result.name">
                        <div class="pointer-events-none">
                            <div>
                                <span x-text="result.name"></span><span class="text-gray-600" x-text="', ' + result.detail" x-show="result.detail"></span>
                            </div>
                            <div x-show="result.serving_size">
                                <div class="text-sm text-gray-600" x-text="result.brand" x-show="result.brand"></div>
                                <div class="text-sm">
                                    Serving size <span x-text="result.serving_size_formatted"></span>
                                    <span x-text="result.serving_unit"></span>
                                    (<span x-text="result.serving_weight"></span>g)
                                </div>
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

@once
    @push('scripts')
        <script type="text/javascript">
            let picker = () => {
                return {
                    searching: false,
                    results: [],
                    search: {
                        ['@input.debounce.400ms']($event) {
                            if ($event.target.value !== '') {
                                fetch('{{ route('ingredient-picker.search') }}?term=' + $event.target.value)
                                    .then(response => response.json())
                                    .then(data => {
                                        this.results = data;
                                        this.searching = true;
                                    });
                            }
                        },
                        ['@focusout.debounce.200ms']() {
                            this.searching = false;
                        }
                    },
                    ingredient: {
                        ['@click']($event) {
                            let selected = $event.target;
                            if (selected.dataset.id) {
                                this.$refs.ingredients.value = selected.dataset.id;
                                this.$refs.ingredients_type.value = selected.dataset.type;
                                this.$refs.ingredients_name.value = selected.dataset.name;
                                this.searching = false;
                            }
                        }
                    }
                }
            }
        </script>
    @endpush
@endonce
