<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Recipes</h2>
            <a href="{{ route('recipes.create') }}" class="inline-flex items-center rounded-md font-semibold text-white p-2 bg-green-500 tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-600 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                New Recipe
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-search-view :route="route('api:v1:recipes.index')">
                        <x-slot name="results">
                            <template x-for="recipe in results" :key="recipe">
                                <div class="p-1 border-2 border-black font-sans">
                                    <div class="text-2xl font-extrabold">
                                        <a x-bind:href="recipe.showUrl"
                                           class="hover:text-gray-600" x-text="recipe.name"></a>
                                    </div>
                                    <div class="flex justify-between font-bold border-b-8 border-black">
                                        <div class="leading-snug" x-text="`${recipe.servings} servings`"></div>
                                    </div>
                                    <div class="font-bold text-right">Amount per serving</div>
                                    <div class="flex justify-between items-end font-extrabold">
                                        <div class="text-xl">Calories</div>
                                        <div class="text-xl" x-text="`${recipe.caloriesPerServing}`"></div>
                                    </div>
                                    <div class="border-t-4 border-black text-sm">
                                        <hr class="border-gray-500"/>
                                        <div class="flex justify-between">
                                            <div class="font-bold">Total Fat</div>
                                            <div x-text="`${recipe.fatPerServing}g`"></div>
                                        </div>
                                        <hr class="border-gray-500"/>
                                        <div class="flex justify-between">
                                            <div class="font-bold">Cholesterol</div>
                                            <div x-text="`${recipe.cholesterolPerServing}g`"></div>
                                        </div>
                                        <hr class="border-gray-500"/>
                                        <div class="flex justify-between">
                                            <div class="font-bold">Sodium</div>
                                            <div x-text="`${recipe.sodiumPerServing}g`"></div>
                                        </div>
                                        <hr class="border-gray-500"/>
                                        <div class="flex justify-between">
                                            <div class="font-bold">Total Carbohydrate</div>
                                            <div x-text="`${recipe.carbohydratesPerServing}g`"></div>
                                        </div>
                                        <hr class="border-gray-500"/>
                                        <div class="flex justify-between">
                                            <div class="font-bold">Protein</div>
                                            <div x-text="`${recipe.proteinPerServing}g`"></div>
                                        </div>
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
