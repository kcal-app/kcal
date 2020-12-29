<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List Ingredients') }}
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
                        @foreach ($ingredients as $ingedient)
                            <div class="p-2 font-light rounded-lg border-2 border-gray-200">
                                <div class="pb-2 lowercase flex justify-between items-baseline">
                                    <div class="text-2xl">
                                        {{ $ingedient->name }}@if($ingedient->detail), <span class="text-gray-500">{{ $ingedient->detail }}</span>@endif
                                    </div>
                                    <div class="text-right text-sm">
                                        @if ($ingedient->unit_weight)
                                            {{ $ingedient->unit_weight }}g each
                                        @else
                                            {{ $ingedient->cup_weight }}g per cup
                                        @endif
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 text-sm border-t-8 border-black pt-2">
                                    <div class="col-span-2 text-xs text-right">Amount per 100g</div>
                                    <div class="font-extrabold text-lg border-b-4 border-black">Calories</div>
                                    <div class="font-extrabold text-right text-lg border-b-4 border-black">{{$ingedient->calories}}</div>
                                    <div class="font-bold border-b border-gray-300">Fat</div>
                                    <div class="text-right border-b border-gray-300">{{ $ingedient->fat < 1 ? $ingedient->fat * 1000 . "m" : $ingedient->fat }}g</div>
                                    <div class="font-bold border-b border-gray-300">Cholesterol</div>
                                    <div class="text-right border-b border-gray-300">{{ $ingedient->cholesterol < 1 ? $ingedient->cholesterol * 1000 . "m" : $ingedient->cholesterol }}g</div>
                                    <div class="font-bold border-b border-gray-300">Sodium</div>
                                    <div class="text-right border-b border-gray-300">{{ $ingedient->sodium < 1 ? $ingedient->sodium * 1000 . "m" : $ingedient->sodium }}g</div>
                                    <div class="font-bold border-b border-gray-300">Carbohydrates</div>
                                    <div class="text-right border-b border-gray-300">{{ $ingedient->carbohydrates < 1 ? $ingedient->carbohydrates * 1000 . "m" : $ingedient->carbohydrates }}g</div>
                                    <div class="font-bold">Protein</div>
                                    <div class="text-right">{{$ingedient->protein}}g</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
