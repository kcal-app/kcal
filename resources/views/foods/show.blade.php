<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex flex-auto">
            {{ $food->name }}
            <a class="ml-2 text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm"
               href="{{ route('foods.edit', $food) }}">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                </svg>
            </a>
            <a class="h-6 w-6 text-red-500 hover:text-red-700 hover:border-red-300 float-right text-sm"
               href="{{ route('foods.delete', $food) }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </a>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- TODO: tags, recipes, etc. -->
                    <h3 class="text-2xl font-extrabold">
                        {{ $food->name }}@if($food->detail), <span class="text-2xl font-extrabold">{{ $food->detail }}</span>@endif
                    </h3>
                    @if($food->brand)
                        <div class="text-2xl font-extrabold">{{ $food->brand }}</div>
                    @endif
                    <div class="p-1 mb-2 border-2 border-black font-sans md:w-72">
                        <div class="text-3xl font-extrabold leading-none">Nutrition Facts</div>
                        <div class="flex justify-between font-bold border-b-8 border-black">
                            <div>Serving size</div>
                            <div>
                                {{ $food->servingSizeFormatted }}
                                {{ $food->servingUnitFormatted ?? $food->name }}
                                ({{ $food->serving_weight }}g)
                            </div>
                        </div>
                        <div class="font-bold text-right">Amount per serving</div>
                        <div class="flex justify-between items-end font-extrabold">
                            <div class="text-3xl">Calories</div>
                            <div class="text-4xl">{{ $food->calories }}</div>
                        </div>
                        <div class="border-t-4 border-black text-sm">
                            <hr class="border-gray-500"/>
                            <div class="flex justify-between">
                                <div class="font-bold">Total Fat</div>
                                <div>{{ $food->fat }}g</div>
                            </div>
                            <hr class="border-gray-500"/>
                            <div class="flex justify-between">
                                <div class="font-bold">Cholesterol</div>
                                <div>{{ $food->cholesterol }}mg</div>
                            </div>
                            <hr class="border-gray-500"/>
                            <div class="flex justify-between">
                                <div class="font-bold">Sodium</div>
                                <div>{{ $food->sodium }}mg</div>
                            </div>
                            <hr class="border-gray-500"/>
                            <div class="flex justify-between">
                                <div class="font-bold">Total Carbohydrate</div>
                                <div>{{ $food->carbohydrates }}g</div>
                            </div>
                            <hr class="border-gray-500"/>
                            <div class="flex justify-between">
                                <div class="font-bold">Protein</div>
                                <div>{{ $food->protein }}g</div>
                            </div>
                        </div>
                    </div>
                    @if($food->source)
                        <div class="mb-2 text-gray-500 text-sm">
                            <span class="font-extrabold">Source:</span>
                            @if(filter_var($food->source, FILTER_VALIDATE_URL))
                                <a href="{{ $food->source }}">{{ $food->source }}</a>
                            @else
                                {{ $food->source }}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
