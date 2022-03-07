<x-app-layout>
    <x-slot name="title">Duplicate {{ $recipe->name }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Duplicate {{ $recipe->name }}?
        </h1>
    </x-slot>
    <form method="POST" action="{{ route('recipes.duplicate', $recipe) }}">
        @csrf
        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
            <!-- Name -->
            <div class="flex-auto">
                <x-inputs.label for="name" value="New recipe name" />

                <x-inputs.input name="name"
                                type="text"
                                class="block mt-1 w-full"
                                :value="old('name', 'Copy of ' . $recipe->name)"
                                required />
            </div>
        </div>
        <div class="flex items-center justify-start mt-4">
            <x-inputs.button class="bg-red-800 hover:bg-red-700">
                Duplicate
            </x-inputs.button>
            <a class="ml-3 text-gray-500 hover:text-gray-700" href="{{ route('recipes.show', $recipe) }}">
                Cancel</a>
        </div>
    </form>
</x-app-layout>
