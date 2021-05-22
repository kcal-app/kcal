<x-app-layout>
    <x-slot name="title">My Journal - {{ $date->format('D, j M Y') }}</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="leading-tight text-center">
                <div class="text-2xl font-semibold text-gray-800">My Journal</div>
                <div class="flex items-center space-x-2">
                    <div>
                        <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                           href="{{ route(Route::current()->getName(), ['date' => $date->copy()->subDay(1)->toDateString()]) }}">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <div class="text-base text-gray-500">
                        <form x-data method="GET" action="{{ route('journal-entries.index') }}">
                            <x-inputs.input name="date"
                                            type="date"
                                            class="border-0 shadow-none p-0 text-center"
                                            :value="$date->toDateString()"
                                            x-on:change="$el.submit();"
                                            required />
                        </form>
                    </div>
                    <div>
                        <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                           href="{{ route(Route::current()->getName(), ['date' => $date->copy()->addDay(1)->toDateString()]) }}">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </h1>
            <x-button-link.green href="{{ route('journal-entries.create', ['date' => $date->format('Y-m-d')]) }}" class="text-sm">
                Add Entry
            </x-button-link.green>
        </div>
    </x-slot>
    <div class="flex align-top flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
        <div class="w-full sm:w-5/12 lg:w-4/12">
            <div class="flex justify-between items-baseline">
                <h3 class="font-semibold text-lg text-gray-800">{{ $date->format('D, j M Y') }}</h3>
                <div class="text-gray-700">{{ $entries->count() }} {{ \Illuminate\Support\Pluralizer::plural('entry', $entries->count()) }}</div>
            </div>
            <div class="text-right border-t-8 border-black text-sm pt-2">% Daily goal</div>
            <div class="flex justify-between items-baseline border-b-4 border-black">
                <div>
                    <span class="font-extrabold text-2xl">Calories</span>
                    <span class="text-lg">{{ number_format($sums['calories']) }}</span>
                </div>
                <div class="font-extrabold text-right text-lg">
                    {{ $goalProgress['calories'] ?? 'N/A' }}
                </div>
            </div>
            <div class="flex justify-between items-baseline border-b border-gray-300 text-sm">
                <div>
                    <span class="font-bold">Fat</span>
                    {{ number_format($sums['fat']) }}g
                </div>
                <div class="text-right">
                    {{ $goalProgress['fat'] ?? 'N/A' }}
                </div>
            </div>
            <div class="flex justify-between items-baseline border-b border-gray-300 text-sm">
                <div>
                    <span class="font-bold">Cholesterol</span>
                    {{ number_format($sums['cholesterol']) }}mg
                </div>
                <div class="text-right">
                    {{ $goalProgress['cholesterol'] ?? 'N/A' }}
                </div>
            </div>
            <div class="flex justify-between items-baseline border-b border-gray-300 text-sm">
                <div>
                    <span class="font-bold">Sodium</span>
                    {{ number_format($sums['sodium']) }}mg
                </div>
                <div class="text-right">
                    {{ $goalProgress['sodium'] ?? 'N/A' }}
                </div>
            </div>
            <div class="flex justify-between items-baseline border-b border-gray-300 text-sm">
                <div>
                    <span class="font-bold">Carbohydrates</span>
                    {{ number_format($sums['carbohydrates']) }}g
                </div>
                <div class="text-right">
                    {{ $goalProgress['carbohydrates'] ?? 'N/A' }}
                </div>
            </div>
            <div class="flex justify-between items-baseline text-sm">
                <div>
                    <span class="font-bold">Protein</span>
                    {{ number_format($sums['protein']) }}g
                </div>
                <div class="text-right">
                    {{ $goalProgress['protein'] ?? 'N/A' }}
                </div>
            </div>
            <section class="pt-2" x-data="{ showGoalChangeForm: false }">
                <h4 class="font-semibold text-lg">
                    Goal
                    <span class="text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 font-normal cursor-pointer"
                          x-show="!showGoalChangeForm"
                          x-on:click="showGoalChangeForm = !showGoalChangeForm">[change]</span>
                </h4>
                <div x-show="!showGoalChangeForm">
                    @empty($currentGoal)
                        <div class="italic">No goal.</div>
                    @else
                        <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                           href="{{ route('goals.show', $currentGoal) }}">
                            {{ $currentGoal->name }}
                        </a>
                    @endempty
                </div>
                <div x-show="showGoalChangeForm">
                    <form method="POST" action="{{ route('journal-dates.update.goal', $journalDate) }}">
                        @csrf
                        <x-inputs.select name="goal"
                                         class="block w-full"
                                         :options="$goalOptions ?? []"
                                         :selectedValue="$currentGoal?->id ?? null">
                        </x-inputs.select>
                        <div class="flex items-center justify-start mt-4">
                            <x-inputs.button class="bg-green-800 hover:bg-green-700">Change Goal</x-inputs.button>
                            <x-button-link.red class="ml-3" x-on:click="showGoalChangeForm = !showGoalChangeForm">
                                Cancel
                            </x-button-link.red>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <div class="w-full sm:w-3/5 md:w-2/3 lg:w-3/4 flex flex-col space-y-4">
            @foreach(['breakfast', 'lunch', 'dinner', 'snacks'] as $meal)
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">
                        <div class="flex items-center">
                            <div>{{ Str::ucfirst($meal) }}</div>
                            <div class="ml-2 w-full"><hr/></div>
                        </div>
                        <span class="text-sm text-gray-500">
                        @foreach(\App\Support\Nutrients::all()->sortBy('weight') as $nutrient)
                            {{ \App\Support\Nutrients::round($entries->where('meal', $meal)->sum($nutrient['value']), $nutrient['value']) }}{{ $nutrient['unit'] }}
                            {{ $nutrient['value'] }}@if(!$loop->last), @endif
                        @endforeach
                    </span>
                    </h3>
                    @forelse($entries->where('meal', $meal) as $entry)
                        <details>
                            <summary>{{ $entry->summary }}</summary>
                            <div class="border-blue-100 border-2 p-2 ml-4">
                                <div class="float-right">
                                    <a class="h-6 w-6 text-red-500 hover:text-red-700 hover:border-red-300 float-right text-sm"
                                       href="{{ route('journal-entries.delete', $entry) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                                <div>
                                    <span class="font-bold">nutrients:</span>
                                    @foreach(\App\Support\Nutrients::all()->sortBy('weight') as $nutrient)
                                        {{ \App\Support\Nutrients::round($entry->{$nutrient['value']}, $nutrient['value']) }}{{ $nutrient['unit'] }}
                                        {{ $nutrient['value'] }}@if(!$loop->last), @endif
                                    @endforeach
                                </div>
                                @if($entry->foods()->exists())
                                    <div>
                                        <span class="font-bold">foods:</span>
                                        @foreach($entry->foods as $food)
                                            <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                               href="{{ route('foods.show', $food) }}">
                                                {{ $food->name }}</a>@if(!$loop->last), @endif
                                        @endforeach
                                    </div>
                                @endif
                                @if($entry->recipes()->exists())
                                    <div>
                                        <span class="font-bold">recipes:</span>
                                        @foreach($entry->recipes as $recipe)
                                            <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                               href="{{ route('recipes.show', $recipe) }}">
                                                {{ $recipe->name }}</a>@if(!$loop->last), @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </details>
                    @empty
                        <em>No entries.</em>
                    @endforelse
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
