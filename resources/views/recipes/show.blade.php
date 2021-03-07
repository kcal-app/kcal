<x-app-layout>
    <x-slot name="title">{{ $recipe->name }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight flex flex-auto">
            {{ $recipe->name }}
            <a class="ml-2 text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm"
               href="{{ route('recipes.edit', $recipe) }}">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                </svg>
            </a>
            <a class="h-6 w-6 text-red-500 hover:text-red-700 hover:border-red-300 float-right text-sm"
               href="{{ route('recipes.delete', $recipe) }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </a>
        </h1>
    </x-slot>
    <div class="flex flex-col-reverse justify-between pb-4 sm:flex-row">
        <div x-data="{showNutrientsSummary: false}">
            @if($recipe->description_html)
                <section class="mb-2 prose prose-lg md:prose-xl">
                    {!! $recipe->description_html !!}
                </section>
            @endif
            @if(!$recipe->tags->isEmpty())
                <section class="mb-2 text-gray-700 text-sm">
                    <h1 class="font-extrabold inline">Tags:</h1>
                    {{ implode(', ', $recipe->tags->pluck('name')->all()) }}
                </section>
            @endif
            @if($recipe->time_total > 0)
                <section class="flex space-x-4">
                    <div>
                        <h1 class="mb-2 font-bold text-lg">Prep time</h1>
                        <p class="mb-2 text-gray-800">{{ $recipe->time_prep }} minutes</p>
                    </div>
                    <div>
                        <h1 class="mb-2 font-bold text-lg">Active time</h1>
                        <p class="mb-2 text-gray-800">{{ $recipe->time_active }} minutes</p>
                    </div>
                    <div>
                        <h1 class="mb-2 font-bold text-lg">Total time</h1>
                        <p class="mb-2 text-gray-800">{{ $recipe->time_total }} minutes</p>
                    </div>
                </section>
            @endif
            <section x-data="{showNutrientsSummary: false}">
                <h1 class="mb-2 font-bold text-2xl">
                    Ingredients
                    <span class="text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 font-normal cursor-pointer"
                          x-on:click="showNutrientsSummary = !showNutrientsSummary">[toggle nutrients]</span>
                </h1>
                <ul class="space-y-2">
                    @foreach($recipe->ingredientAmounts as $ia)
                        <li>
                            {{ \App\Support\Number::fractionStringFromFloat($ia->amount) }}
                            @if($ia->unitFormatted){{ $ia->unitFormatted }}@endif
                            @if($ia->ingredient->type === \App\Models\Recipe::class)
                                <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                   href="{{ route('recipes.show', $ia->ingredient) }}">
                                    {{ $ia->ingredient->name }}
                                </a>
                            @else
                                {{ $ia->ingredient->name }}@if($ia->ingredient->detail), {{ $ia->ingredient->detail }}@endif
                            @endif
                            @if($ia->detail)<span class="text-gray-500">{{ $ia->detail }}</span>@endif
                            <div x-show="showNutrientsSummary" class="text-sm text-gray-500">{{ $ia->nutrients_summary }}</div>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
        <aside>
            <div class="p-1 border-2 border-black font-sans sm:ml-4 md:w-72">
                <div class="text-3xl font-extrabold leading-none">Nutrition Facts</div>
                <div class="leading-snug">{{ $recipe->servings }} {{ \Illuminate\Support\Str::plural('serving', $recipe->servings ) }}</div>
                @if($recipe->serving_weight)
                    <div class="flex justify-between items-end font-extrabold">
                        <div>Serving weight</div>
                        <div>{{ $recipe->serving_weight }}g</div>
                    </div>
                @endif
                <div class="font-bold text-right border-t-8 border-black">Amount per serving</div>
                <div class="flex justify-between items-end font-extrabold">
                    <div class="text-3xl">Calories</div>
                    <div class="text-4xl">{{ $recipe->caloriesPerServing() }}</div>
                </div>
                <div class="border-t-4 border-black text-sm">
                    <hr class="border-gray-500"/>
                    <div class="flex justify-between">
                        <div class="font-bold">Total Fat</div>
                        <div>{{ $recipe->fatPerServing() }}g</div>
                    </div>
                    <hr class="border-gray-500"/>
                    <div class="flex justify-between">
                        <div class="font-bold">Cholesterol</div>
                        <div>{{ $recipe->cholesterolPerServing() }}mg</div>
                    </div>
                    <hr class="border-gray-500"/>
                    <div class="flex justify-between">
                        <div class="font-bold">Sodium</div>
                        <div>{{ $recipe->sodiumPerServing() }}mg</div>
                    </div>
                    <hr class="border-gray-500"/>
                    <div class="flex justify-between">
                        <div class="font-bold">Total Carbohydrate</div>
                        <div>{{ $recipe->carbohydratesPerServing() }}g</div>
                    </div>
                    <hr class="border-gray-500"/>
                    <div class="flex justify-between">
                        <div class="font-bold">Protein</div>
                        <div>{{ $recipe->proteinPerServing() }}g</div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
    <section>
        <h1 class="mb-2 font-bold text-2xl">Steps</h1>
        <div class="prose prose-xl md:prose-2xl">
            <ol>
                @foreach($recipe->steps as $step)
                    <li>{{ $step->step }}</li>
                @endforeach
            </ol>
        </div>
    </section>
    @if($recipe->source)
        <footer class="mb-2 text-gray-500 text-sm">
            <h1 class="font-extrabold inline">Source:</h1>
            @if(filter_var($recipe->source, FILTER_VALIDATE_URL))
                <a href="{{ $recipe->source }}">{{ $recipe->source }}</a>
            @else
                {{ $recipe->source }}
            @endif
        </footer>
    @endif
</x-app-layout>
