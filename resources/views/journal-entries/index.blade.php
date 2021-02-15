<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="leading-tight text-center">
                <div class="text-2xl font-semibold text-gray-800">{{ Auth::user()->name }}'s Journal</div>
                <div class="flex items-center space-x-2">
                    <div>
                        <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                           href="{{ route(Route::current()->getName(), ['date' => $date->copy()->subDay(1)->toDateString()]) }}">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <div class="text-base text-gray-500">{{ $date->format('D, j M Y') }}</div>
                    <div>
                        <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                           href="{{ route(Route::current()->getName(), ['date' => $date->copy()->addDay(1)->toDateString()]) }}">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </h2>
            <a href="{{ route('journal-entries.create', ['date' => $date->format('Y-m-d')]) }}" class="inline-flex items-center rounded-md font-semibold text-white p-2 bg-green-500 tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-600 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                New Entry
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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
                                    {{ $dailyGoals['calories'] ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="flex justify-between items-baseline border-b border-gray-300 text-sm">
                                <div>
                                    <span class="font-bold">Fat</span>
                                    {{ number_format($sums['fat']) }}g
                                </div>
                                <div class="text-right">
                                    {{ $dailyGoals['fat'] ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="flex justify-between items-baseline border-b border-gray-300 text-sm">
                                <div>
                                    <span class="font-bold">Cholesterol</span>
                                    {{ number_format($sums['cholesterol']) }}mg
                                </div>
                                <div class="text-right">
                                    {{ $dailyGoals['cholesterol'] ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="flex justify-between items-baseline border-b border-gray-300 text-sm">
                                <div>
                                    <span class="font-bold">Sodium</span>
                                    {{ number_format($sums['sodium']) }}mg
                                </div>
                                <div class="text-right">
                                    {{ $dailyGoals['sodium'] ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="flex justify-between items-baseline border-b border-gray-300 text-sm">
                                <div>
                                    <span class="font-bold">Carbohydrates</span>
                                    {{ number_format($sums['carbohydrates']) }}g
                                </div>
                                <div class="text-right">
                                    {{ $dailyGoals['carbohydrates'] ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="flex justify-between items-baseline text-sm">
                                <div>
                                    <span class="font-bold">Protein</span>
                                    {{ number_format($sums['protein']) }}g
                                </div>
                                <div class="text-right">
                                    {{ $dailyGoals['protein'] ?? 'N/A' }}
                                </div>
                            </div>
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
                                        @foreach(\App\Support\Nutrients::$all as $nutrient)
                                                {{ round($entries->where('meal', $meal)->sum($nutrient['value']), 2) }}{{ $nutrient['unit'] }}
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
                                                    @foreach(\App\Support\Nutrients::$all as $nutrient)
                                                        {{ round($entry->{$nutrient['value']}, 2) }}{{ $nutrient['unit'] }}
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
