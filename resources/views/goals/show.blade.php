<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex flex-auto">
            {{ $goal->summary }}
            <a class="ml-2 text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm"
               href="{{ route('goals.edit', $goal) }}">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                </svg>
            </a>
            <a class="h-6 w-6 text-red-500 hover:text-red-700 hover:border-red-300 float-right text-sm"
               href="{{ route('goals.delete', $goal) }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </a>
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-y-1 gap-x-3 max-w-md inline-grid">
                        <div class="font-bold">From</div>
                        <div>{{ $goal->from?->toDateString() ?? 'Any' }}</div>
                        <div class="font-bold">To</div>
                        <div>{{ $goal->to?->toDateString() ?? 'Any' }}</div>
                        <div class="font-bold">Frequency</div>
                        <div>{{ \Illuminate\Support\Str::ucfirst($frequencyOptions[$goal->frequency]['label']) }}</div>
                        <div class="font-bold">Trackable</div>
                        <div>{{ \Illuminate\Support\Str::ucfirst($nameOptions[$goal->name]['label']) }}</div>
                        <div class="font-bold">Goal</div>
                        <div>{{ $goal->goal }}{{ $nameOptions[$goal->name]['unit'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
