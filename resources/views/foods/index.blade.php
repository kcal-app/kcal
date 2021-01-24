<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Foods') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div x-data="foods()" x-init="loadMore()">
                        <x-inputs.input type="text"
                                        name="search"
                                        placeholder="Search..."
                                        autocomplete="off"
                                        class="w-full mb-4"
                                        @input.debounce.400ms="search($event)" />
                        <div class="grid grid-cols-3 gap-4">
                            <template x-for="food in foods" :key="food">
                                <div class="p-2 font-light rounded-t border-2 border-gray-400">
                                    <a class="h-6 w-6 text-gray-500 hover:text-gray-700 hover:border-gray-300 float-right text-sm"
                                       x-bind:href="food.editUrl">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <div class="text-2xl">
                                        <span x-text="food.name"></span><span class="text-gray-500" x-text="`, ${food.detail}`" x-show="food.detail"></span>
                                    </div>
                                    <div class="text-xl text-gray-600" x-text="food.brand" x-show="food.brand"></div>
                                    <div class="font-bold">
                                        Serving size <span x-text="food.servingSizeFormatted"></span>
                                        <span x-text="food.servingUnit"></span>
                                        <span x-text="`(${food.servingWeight}g)`"></span>
                                    </div>
                                    <div class="grid grid-cols-2 text-sm border-t-8 border-black pt-2">
                                        <div class="col-span-2 text-xs font-bold text-right">Amount per serving</div>
                                        <div class="font-extrabold text-lg border-b-4 border-black">Calories</div>
                                        <div class="font-extrabold text-right text-lg border-b-4 border-black" x-text="`${food.calories}g`"></div>
                                        <div class="font-bold border-b border-gray-300">Fat</div>
                                        <div class="text-right border-b border-gray-300" x-text="`${food.fat}g`"></div>
                                        <div class="font-bold border-b border-gray-300">Cholesterol</div>
                                        <div class="text-right border-b border-gray-300" x-text="`${Math.round(food.cholesterol*1000)}mg`"></div>
                                        <div class="font-bold border-b border-gray-300">Sodium</div>
                                        <div class="text-right border-b border-gray-300" x-text="`${Math.round(food.sodium*1000)}mg`">{</div>
                                        <div class="font-bold border-b border-gray-300">Carbohydrates</div>
                                        <div class="text-right border-b border-gray-300" x-text="`${food.carbohydrates}g`"></div>
                                        <div class="font-bold">Protein</div>
                                        <div class="text-right" x-text="`${food.protein}g`"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <x-inputs.button
                            class="text-xl mt-4"
                            color="blue"
                            type="button"
                            x-show="morePages"
                            @click.prevent="loadMore()">
                            Load more
                        </x-inputs.button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @once
        @push('scripts')
            <script type="text/javascript">
                let foods = () => {
                    return {
                        foods: [],
                        number: 1,
                        size: 12,
                        morePages: true,
                        searchTerm: '{{ $defaultSearch ?? null }}',
                        reset() {
                            this.foods = [];
                            this.number = 1;
                            this.searchTerm = null;
                            this.morePages = true;
                        },
                        loadMore() {
                            let url = `{{ route('api:v1:foods.index') }}?page[number]=${this.number}&page[size]=${this.size}`;
                            if (this.searchTerm) {
                                url += `&filter[search]=${this.searchTerm}`;
                            }
                            fetch(url)
                                .then(response => response.json())
                                .then(data => {
                                    this.foods = [...this.foods, ...data.data.map(food => food.attributes)];
                                    if (this.number >= data.meta.page['last-page']) {
                                        this.morePages = false;
                                    } else {
                                        this.number++;
                                    }
                                });
                        },
                        search(e) {
                            this.reset();
                            if (e.target.value !== '') {
                                this.searchTerm = e.target.value;
                                this.loadMore();
                            }
                            else {
                                this.loadMore();
                            }
                        }
                    }
                }
            </script>
        @endpush
    @endonce
</x-app-layout>
