<x-app-layout>
    <x-slot name="title">{{ $food->name }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight flex flex-auto items-center">
            <div>
                {{ $food->name }}@if($food->detail), {{ $food->detail }}@endif
            </div>
        </h1>
    </x-slot>
    <div class="flex flex-col justify-between pb-4 md:flex-row md:space-x-4">
        <div class="flex-1">
            <section class="flex flex-col space-y-2">
                @if($food->brand)
                    <h1 class="font-bold text-2xl">Brand</h1>
                    <div class="flex flex-wrap">
                        {{ $food->brand }}
                    </div>
                @endif
                @if($food->notes)
                    <h1 class="font-bold text-2xl">Notes</h1>
                    <div class="flex flex-wrap">
                        {{ $food->notes }}
                    </div>
                @endif
                @if(!$food->tags->isEmpty())
                    <h1 class="font-bold text-2xl">Tags</h1>
                    <div class="flex flex-wrap">
                        @foreach ($food->tags as $tag)
                            <span class="m-1 bg-gray-200 rounded-full px-2 leading-loose">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif
                @if($food->description)
                    <h1 class="font-bold text-2xl">Description</h1>
                    <p class="text-gray-800">{{ $food->description }}</p>
                @endif
                @if($food->source)
                    <h1 class="font-bold text-2xl">Source</h1>
                    <p>
                        @if(filter_var($food->source, FILTER_VALIDATE_URL))
                            <a class="text-gray-500 hover:text-gray-700" href="{{ $food->source }}">{{ $food->source }}</a>
                        @else
                            {{ $food->source }}
                        @endif
                    </p>
                @endif
                @if(!$food->ingredientAmountRelationships->isEmpty())
                    <h1 class="font-bold text-2xl">Recipes</h1>
                    <ul class="list-disc list-inside ml-3 space-y-1">
                        @foreach ($food->ingredientAmountRelationships as $ia)
                            <li> <a class="text-gray-500 hover:text-gray-700"
                                    href="{{ route('recipes.show', $ia->parent) }}">{{ $ia->parent->name }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </div>
        <aside class="flex flex-col space-y-4 mt-8 sm:mt-0 sm:max-w-xs">
            <section class="p-1 mb-2 border-2 border-black font-sans md:w-72">
                <h1 class="text-3xl font-extrabold leading-none">Nutrition Facts</h1>
                <section class="flex justify-between font-bold border-b-8 border-black">
                    <h1>Serving size</h1>
                    <div>
                        {{ $food->servingSizeFormatted }}
                        {{ $food->servingUnitFormatted ?? $food->name }}
                        ({{ $food->serving_weight }}g)
                    </div>
                </section>
                <h2 class="font-bold text-right">Amount per serving</h2>
                <section class="flex justify-between items-end font-extrabold">
                    <h1 class="text-3xl">Calories</h1>
                    <div class="text-4xl">{{ $food->calories }}</div>
                </section>
                <div class="border-t-4 border-black text-sm">
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Total Fat</h1>
                        <div>{{ $food->fat }}g</div>
                    </section>
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Cholesterol</h1>
                        <div>{{ $food->cholesterol }}mg</div>
                    </section>
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Sodium</h1>
                        <div>{{ $food->sodium }}mg</div>
                    </section>
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Total Carbohydrate</h1>
                        <div>{{ $food->carbohydrates }}g</div>
                    </section>
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Protein</h1>
                        <div>{{ $food->protein }}g</div>
                    </section>
                </div>
            </section>
            <hr />
            <section class="flex flex-col space-y-2">
                <x-button-link.base href="{{ route('foods.edit', $food) }}">
                    Edit Food
                </x-button-link.base>
                <x-button-link.red href="{{ route('foods.delete', $food) }}">
                    Delete Food
                </x-button-link.red>
            </section>
        </aside>
    </div>
</x-app-layout>
