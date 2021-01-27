<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Foods</h2>
            <a href="{{ route('foods.create') }}" class="inline-flex items-center rounded-md font-semibold text-white p-2 bg-green-500 tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-600 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                New Food
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-search-view :route="route('api:v1:foods.index')">
                        <x-slot name="results">
                            <template x-for="food in results" :key="food">
                                <div class="p-2 font-light rounded-t border-2 border-gray-400">
                                    <div class="flex justify-between items-baseline">
                                        <div class="text-2xl">
                                            <a x-bind:href="food.showUrl"
                                               class="text-gray-600 hover:text-gray-800">
                                                <span x-text="food.name"></span><span class="text-gray-500" x-text="`, ${food.detail}`" x-show="food.detail"></span>
                                            </a>
                                        </div>
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
                        </x-slot>
                    </x-search-view>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
