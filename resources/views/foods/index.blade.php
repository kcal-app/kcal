<x-app-layout>
    <x-slot name="title">Foods</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-2xl text-gray-800 leading-tight">Foods</h1>
            <x-button-link.green href="{{ route('foods.create') }}" class="text-sm">
                Add Food
            </x-button-link.green>
        </div>
    </x-slot>
    <x-search-view :route="route('api:v1:foods.index')" :tags="$tags">
        <x-slot name="results">
            <template x-for="food in results" :key="food">
                <article class="p-1 border-2 border-black font-sans">
                    <h1 class="text-2xl lowercase font-extrabold leading-none">
                        <a x-bind:href="food.showUrl"
                           class="hover:text-gray-600">
                            <span x-text="food.name"></span><span class="text-gray-500" x-text="`, ${food.detail}`" x-show="food.detail"></span>
                        </a>
                    </h1>
                    <h2 class="lowercase text-lg text-gray-600" x-text="food.brand" x-show="food.brand"></h2>
                    <section class="flex justify-between font-bold border-b-8 border-black">
                        <h1>Serving size</h1>
                        <p>
                            <span x-text="food.servingSizeFormatted"></span>
                            <span x-text="food.servingUnitFormatted ?? food.name"></span>
                            <span x-text="`(${food.servingWeight}g)`"></span>
                        </p>
                    </section>
                    <h2 class="font-bold text-right">Amount per serving</h2>
                    <section class="flex justify-between items-end font-extrabold">
                        <h1 class="text-xl">Calories</h1>
                        <div class="text-xl" x-text="food.calories"></div>
                    </section>
                    <div class="border-t-4 border-black text-sm">
                        <hr class="border-gray-500"/>
                        <section class="flex justify-between">
                            <h1 class="font-bold">Total Fat</h1>
                            <div x-text="`${food.fat}g`"></div>
                        </section>
                        <hr class="border-gray-500"/>
                        <section class="flex justify-between">
                            <h1 class="font-bold">Cholesterol</h1>
                            <div x-text="`${food.cholesterol}mg`"></div>
                        </section>
                        <hr class="border-gray-500"/>
                        <section class="flex justify-between">
                            <h1 class="font-bold">Sodium</h1>
                            <div x-text="`${food.sodium}mg`"></div>
                        </section>
                        <hr class="border-gray-500"/>
                        <section class="flex justify-between">
                            <h1 class="font-bold">Total Carbohydrate</h1>
                            <div x-text="`${food.carbohydrates}g`"></div>
                        </section>
                        <hr class="border-gray-500"/>
                        <section class="flex justify-between">
                            <h1 class="font-bold">Protein</h1>
                            <div x-text="`${food.protein}g`"></div>
                        </section>
                    </div>
                </article>
            </template>
        </x-slot>
    </x-search-view>
</x-app-layout>
