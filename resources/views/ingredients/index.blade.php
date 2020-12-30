<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ingredients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('message'))
                <div class="bg-green-200 border-2 border-green-600 p-2 mb-2">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ($ingredients as $ingredient)
                            <div class="p-2 font-light rounded-lg border-2 border-gray-200">
                                <div class="pb-2 lowercase flex justify-between items-baseline">
                                    <div class="text-2xl">
                                        {{ $ingredient->name }}@if($ingredient->detail), <span class="text-gray-500">{{ $ingredient->detail }}</span>@endif
                                    </div>
                                    <div class="text-right text-sm">
                                        @if ($ingredient->unit_weight)
                                            {{ $ingredient->unit_weight }}g each
                                        @else
                                            {{ $ingredient->cup_weight }}g per cup
                                        @endif
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 text-sm border-t-8 border-black pt-2">
                                    <div class="col-span-2 text-xs text-right">Amount per 100g</div>
                                    <div class="font-extrabold text-lg border-b-4 border-black">Calories</div>
                                    <div class="font-extrabold text-right text-lg border-b-4 border-black">{{$ingredient->calories}}</div>
                                    <div class="font-bold border-b border-gray-300">Fat</div>
                                    <div class="text-right border-b border-gray-300">{{ $ingredient->fat < 1 ? $ingredient->fat * 1000 . "m" : $ingredient->fat }}g</div>
                                    <div class="font-bold border-b border-gray-300">Cholesterol</div>
                                    <div class="text-right border-b border-gray-300">{{ $ingredient->cholesterol < 1 ? $ingredient->cholesterol * 1000 . "m" : $ingredient->cholesterol }}g</div>
                                    <div class="font-bold border-b border-gray-300">Sodium</div>
                                    <div class="text-right border-b border-gray-300">{{ $ingredient->sodium < 1 ? $ingredient->sodium * 1000 . "m" : $ingredient->sodium }}g</div>
                                    <div class="font-bold border-b border-gray-300">Carbohydrates</div>
                                    <div class="text-right border-b border-gray-300">{{ $ingredient->carbohydrates < 1 ? $ingredient->carbohydrates * 1000 . "m" : $ingredient->carbohydrates }}g</div>
                                    <div class="font-bold">Protein</div>
                                    <div class="text-right">{{ $ingredient->protein < 1 ? $ingredient->protein * 1000 . "m" : $ingredient->protein }}g</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
