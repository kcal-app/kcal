@php use App\Models\IngredientAmount; @endphp
@php use App\Support\Number; @endphp
@php use App\Models\Recipe; @endphp
@php use App\Models\RecipeSeparator; @endphp
<x-app-layout>
    <x-slot name="title">{{ $recipe->name }}</x-slot>
    @if(!empty($feature_image))
        <x-slot name="feature_image">{{ $feature_image }}</x-slot>
    @endisset
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight flex flex-auto">
            {{ $recipe->name }}
        </h1>
    </x-slot>
    <div class="flex flex-col-reverse justify-between md:flex-row md:space-x-4">
        <div class="flex-1" x-data="{ showNutrientsSummary: false }">
            @if($recipe->time_total > 0)
                <section class="flex justify-between mb-2 p-2 bg-gray-100 rounded max-w-3xl">
                    <div>
                        <h1 class="mb-1 font-bold">Prep time</h1>
                        <p class="text-gray-800 text-sm">{{ $recipe->time_prep }} minutes</p>
                    </div>
                    <div>
                        <h1 class="mb-1 font-bold">Cook time</h1>
                        <p class="text-gray-800 text-sm">{{ $recipe->time_cook }} minutes</p>
                    </div>
                    <div>
                        <h1 class="mb-1 font-bold">Total time</h1>
                        <p class="text-gray-800 text-sm">{{ $recipe->time_total }} minutes</p>
                    </div>
                </section>
            @endif
            @if($recipe->description)
                <section class="mb-2 prose prose-lg">
                    {!! $recipe->description !!}
                </section>
            @endif
            <section x-data="{ showNutrientsSummary: false }">
                <h1 class="mb-2 font-bold text-2xl">
                    Ingredients
                    <span
                        class="text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 font-normal cursor-pointer"
                        x-on:click="showNutrientsSummary = !showNutrientsSummary">[toggle nutrients]</span>
                </h1>
                <div class="prose prose-lg">
                    <ul class="space-y-2">
                        @foreach($recipe->ingredientsList->sortBy('weight') as $item)
                            @if($item::class === IngredientAmount::class)
                                <li>
                                    <span>
                                        {{-- Prevent food with serving size > 1 from incorrectly using formatted
                                             serving unit with number of servings. E.g., for a recipe calling for 1
                                             serving of a food with 4 tbsp. to a serving size show "1 serving" instead
                                             of "1 tbsp." (incorrect). --}}
                                        @if($item->unit === 'serving' && $item->ingredient->serving_size > 1 && ($item->ingredient->serving_unit || $item->ingredient->serving_unit_name))
                                            {{ Number::rationalStringFromFloat($item->amount * $item->ingredient->serving_size) }} {{ $item->unitFormatted }}
                                            <span
                                                class="text-gray-500">({{ Number::rationalStringFromFloat($item->amount) }} {{ \Illuminate\Support\Str::plural('serving', $item->amount ) }})</span>
                                        @else
                                            {{ Number::rationalStringFromFloat($item->amount) }}
                                            @if($item->unitFormatted)
                                                {{ $item->unitFormatted }}
                                            @endif
                                        @endif

                                        @if($item->ingredient->type === Recipe::class)
                                            <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                               href="{{ route('recipes.show', $item->ingredient) }}">
                                                {{ $item->ingredient->name }}
                                            </a>
                                        @else
                                            {{ $item->ingredient->name }}@if($item->ingredient->detail)
                                                , {{ $item->ingredient->detail }}
                                            @endif
                                        @endif
                                        @if($item->detail)
                                            <span class="text-gray-500">{{ $item->detail }}</span>
                                        @endif
                                        <div x-show="showNutrientsSummary"
                                             class="text-sm text-gray-500">{{ $item->nutrients_summary }}</div>
                                    </span>
                                </li>
                            @elseif($item::class === RecipeSeparator::class)
                    </ul>
                </div>
                @if($item->text)
                    <h2 class="mt-3 font-bold">{{ $item->text }}</h2>
                @else
                    <hr class="mt-3 lg:w-1/2"/>
                @endif
                <div class="prose prose-lg">
                    <ul class="space-y-2">
                        @endif
                        @endforeach
                    </ul>
                </div>
            </section>
            <section>
                <h1 class="mb-2 font-bold text-2xl">Steps</h1>
                <div class="prose prose-lg">
                    <ol>
                        @foreach($recipe->steps as $step)
                            <li>{{ $step->step }}</li>
                        @endforeach
                    </ol>
                </div>
            </section>
            <footer class="space-y-2">
                @if(!$recipe->tags->isEmpty())
                    <section>
                        <h1 class="mb-2 font-bold text-2xl">Tags</h1>
                        <div class="flex flex-wrap">
                            @foreach($recipe->tags as $tag)
                                <span
                                    class="m-1 bg-gray-200 rounded-full px-2 leading-loose cursor-default">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </section>
                @endif
                @if($recipe->source)
                    <section>
                        <h1 class="mb-2 font-bold text-2xl">Source</h1>
                        @if(filter_var($recipe->source, FILTER_VALIDATE_URL))
                            <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                               href="{{ $recipe->source }}">{{ $recipe->source }}</a>
                        @else
                            {{ $recipe->source }}
                        @endif
                    </section>
                @endif
            </footer>
        </div>
        <aside class="flex flex-col space-y-4 mb-8 md:mt-0 sm:max-w-xs">
            <div class="p-1 border-2 border-black font-sans md:w-72">
                <div class="text-3xl font-extrabold leading-none">Nutrition Facts</div>
                <div class="leading-snug">
                    {{ $recipe->servings }} {{ \Illuminate\Support\Str::plural('serving', $recipe->servings ) }}
                    @if($recipe->volume)
                        / {{ $recipe->volume_formatted }} {{ \Illuminate\Support\Str::plural('cup', $recipe->volume ) }}
                    @endif
                </div>
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
            <section class="flex flex-col space-y-2">
                <x-log-journalable :journalable="$recipe"></x-log-journalable>
                <x-button-link.gray href="{{ route('recipes.edit', $recipe) }}">
                    Edit Recipe
                </x-button-link.gray>
                <x-button-link.gray href="{{ route('recipes.duplicate.confirm', $recipe) }}">
                    Duplicate Recipe
                </x-button-link.gray>
                <x-button-link.red href="{{ route('recipes.delete', $recipe) }}">
                    Delete Recipe
                </x-button-link.red>
            </section>
        </aside>
    </div>
</x-app-layout>
