@props(['hasError' => false])

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
                            class="w-full{{ $hasError ? ' border-red-600' : '' }}"
                            value="{{ $defaultName ?? '' }}"
                            placeholder="Search..."
                            autocomplete="off"
                            autocapitalize="none"
                            inputmode="search"
                            x-ref="ingredients_name"
                            x-spread="search" />
        </div>
        <div x-show="searching" x-cloak>
            <div class="absolute border-2 border-gray-500 border-b-0 bg-white"
                 x-spread="ingredient">
                <template x-for="result in results" :key="result.id">
                    <div class="p-1 border-b-2 border-gray-500 hover:bg-yellow-300 cursor-pointer" x-bind:data-id="result.id">
                        <div class="pointer-events-none">
                            <div>
                                <span class="font-bold" x-text="result.name"></span><span class="text-gray-600" x-text="', ' + result.detail" x-show="result.detail"></span>
                            </div>
                            <div x-show="result.type === 'App\\Models\\Recipe'">
                                <div x-show="result.serving_weight">
                                    <div class="text-sm">Serving weight <span x-text="result.serving_weight"></span>g</div>
                                </div>
                                <div x-show="result.servings">
                                    <div class="text-sm">Servings: <span x-text="result.servings"></span></div>
                                </div>
                            </div>
                            <div x-show="result.type === 'App\\Models\\Food'">
                                <div class="text-sm text-gray-600" x-text="result.brand" x-show="result.brand"></div>
                                <div class="text-sm">
                                    Serving size <span x-text="result.serving_size_formatted"></span>
                                    <span x-text="result.serving_unit_formatted"></span>
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
                        /**
                         * Executes a search from the input.
                         *
                         * @param {object} $event Input event triggering the search.
                         */
                        ['@input.debounce.400ms']($event) {
                            if ($event.target.value !== '') {
                                fetch(`{{ route('ingredient-picker.search') }}?term=${$event.target.value}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        this.results = data;
                                        this.searching = true;
                                    });
                            }
                            else {
                                this.searching = false;
                            }
                        },

                        /**
                         * Cancels a search on focus out.
                         */
                        ['@focusout.debounce.200ms']() {
                            this.searching = false;
                        }
                    },
                    ingredient: {
                        /**
                         * Handles a "picked" ingredient.
                         *
                         * @param {object} $event Click event for the pick.
                         */
                        ['@click']($event) {
                            let selected = $event.target;
                            if (selected.dataset.id) {
                                const ingredient = this.results.find(result => result.id === Number(selected.dataset.id));

                                // Dispatch an event indicating which ingredient
                                // the was picked.
                                this.$el.dispatchEvent(new CustomEvent('ingredient-picked', {
                                    detail: { ingredient: ingredient },
                                    bubbles: true
                                }));

                                // Set the relevant field values for the picked
                                // ingredient.
                                this.$refs.ingredients.value = ingredient.id;
                                this.$refs.ingredients_type.value = ingredient.type;
                                this.$refs.ingredients_name.value = ingredient.name + (ingredient.detail ? `, ${ingredient.detail}` : '');

                                // Clear search results.
                                this.searching = false;
                                this.results = [];
                            }
                        }
                    }
                }
            }
        </script>
    @endpush
@endonce
