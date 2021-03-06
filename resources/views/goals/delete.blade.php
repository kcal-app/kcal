<x-app-layout>
    <x-slot name="title">Delete Goal</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Delete {{ $goal->goal }} goal?
        </h1>
    </x-slot>
    <form method="POST" action="{{ route('goals.destroy', $goal) }}">
        @method('delete')
        @csrf
        <div class="text-lg pb-3">
            Are you sure what to delete your <span class="font-extrabold">{{ $goal->summary }}</span> goal?
        </div>
        <x-inputs.button class="bg-red-800 hover:bg-red-700">
            Yes, delete
        </x-inputs.button>
        <a class="ml-3 text-gray-500 hover:text-gray-700 hover:border-gray-300"
           href="{{ route('goals.show', $goal) }}">No, do not delete</a>
    </form>
</x-app-layout>
