<x-app-layout>
    <x-slot name="title">Foods</x-slot>
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
    <x-search-view :route="route('api:v1:foods.index')" :tags="$tags">
        <x-slot name="results">
            <template x-for="food in results" :key="food">
                <div class="p-1 border-2 border-black font-sans">
                    <div class="text-2xl lowercase font-extrabold leading-none">
                        <a x-bind:href="food.showUrl"
                           class="hover:text-gray-600">
                            <span x-text="food.name"></span><span class="text-gray-500" x-text="`, ${food.detail}`" x-show="food.detail"></span>
                        </a>
                    </div>
                    <div class="lowercase text-lg text-gray-600" x-text="food.brand" x-show="food.brand"></div>
                    <div class="flex justify-between font-bold border-b-8 border-black">
                        <div>Serving size</div>
                        <div>
                            <span x-text="food.servingSizeFormatted"></span>
                            <span x-text="food.servingUnitFormatted ?? food.name"></span>
                            <span x-text="`(${food.servingWeight}g)`"></span>
                        </div>
                    </div>
                    <div class="font-bold text-right">Amount per serving</div>
                    <div class="flex justify-between items-end font-extrabold">
                        <div class="text-xl">Calories</div>
                        <div class="text-xl" x-text="food.calories"></div>
                    </div>
                    <div class="border-t-4 border-black text-sm">
                        <hr class="border-gray-500"/>
                        <div class="flex justify-between">
                            <div class="font-bold">Total Fat</div>
                            <div x-text="`${food.fat}g`"></div>
                        </div>
                        <hr class="border-gray-500"/>
                        <div class="flex justify-between">
                            <div class="font-bold">Cholesterol</div>
                            <div x-text="`${food.cholesterol}mg`"></div>
                        </div>
                        <hr class="border-gray-500"/>
                        <div class="flex justify-between">
                            <div class="font-bold">Sodium</div>
                            <div x-text="`${food.sodium}mg`"></div>
                        </div>
                        <hr class="border-gray-500"/>
                        <div class="flex justify-between">
                            <div class="font-bold">Total Carbohydrate</div>
                            <div x-text="`${food.carbohydrates}g`"></div>
                        </div>
                        <hr class="border-gray-500"/>
                        <div class="flex justify-between">
                            <div class="font-bold">Protein</div>
                            <div x-text="`${food.protein}g`"></div>
                        </div>
                    </div>
                </div>
            </template>
        </x-slot>
    </x-search-view>
</x-app-layout>
