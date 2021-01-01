<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(":name's Journal", ['name' => Auth::user()->name]) }}
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
                    <div class="flex flex-row justify-between items-center mb-4">
                        <div><a class="text-gray-500 hover:text-gray-700 hover:border-gray-300" href="{{ route(Route::current()->getName(), ['date' => $date->copy()->subDay(1)->toDateString()]) }}">previous</a></div>
                        <div class="font-extrabold text-lg">
                            {{ $date->format('D, j M Y') }}
                        </div>
                        <div><a class="text-gray-500 hover:text-gray-700 hover:border-gray-300" href="{{ route(Route::current()->getName(), ['date' => $date->copy()->addDay(1)->toDateString()]) }}">next</a></div>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">Totals</h3>
                            @foreach($nutrients as $nutrient)
                                {{ round($entries->sum($nutrient), 2) }}g
                                {{ $nutrient }}@if(!$loop->last), @endif
                            @endforeach
                        </div>
                        @foreach(['breakfast', 'lunch', 'dinner', 'snacks'] as $meal)
                            <div>
                                <h3 class="font-semibold text-lg text-gray-800">
                                    {{ Str::ucfirst($meal) }}
                                </h3>
                                <div class="text-xs">
                                    @foreach($nutrients as $nutrient)
                                        {{ round($entries->where('meal', $meal)->sum($nutrient), 2) }}g
                                        {{ $nutrient }}@if(!$loop->last), @endif
                                    @endforeach
                                </div>
                                @forelse($entries->where('meal', $meal) as $entry)
                                    <details>
                                        <summary>{{ $entry->summary }}</summary>
                                        {{ $entry->calories }}
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
</x-app-layout>
