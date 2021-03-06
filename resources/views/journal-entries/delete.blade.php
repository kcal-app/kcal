<x-app-layout>
    <x-slot name="title">Delete Entry</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Delete {{ $entry->summary }}?
        </h1>
    </x-slot>
    <form method="POST" action="{{ route('journal-entries.destroy', $entry) }}">
        @method('delete')
        @csrf
        <div class="text-lg">Are you sure what to delete this journal entry?</div>
        <div class="flex flex-col space-y-2 mt-4 mb-4 text-lg">
            <div>
                <span class="font-bold">Summay:</span>
                <span>{{ $entry->summary }}</span>
            </div>
            <div>
                <span class="font-bold">Date:</span>
                <span>{{ $entry->date->format('D, j M Y') }}</span>
            </div>
            <div>
                <span class="font-bold">Meal:</span>
                <span>{{ $entry->meal }}</span>
            </div>
        </div>
        <x-inputs.button class="bg-red-800 hover:bg-red-700">
            Yes, delete
        </x-inputs.button>
        <a class="ml-3 text-gray-500 hover:text-gray-700 hover:border-gray-300"
           href="{{ route('journal-entries.index') }}">No, do not delete</a>
    </form>
</x-app-layout>
