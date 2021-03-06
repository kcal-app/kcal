<x-app-layout>
    <x-slot name="title">Add Entry</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Add Entry</h1>
            <a href="{{ route('journal-entries.create', ['date' => $default_date->format('Y-m-d')]) }}" class="inline-flex items-center rounded-md font-semibold text-white p-2 bg-green-500 tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-600 disabled:opacity-25 transition ease-in-out duration-150">
                Add by Recipes/Food
            </a>
        </div>
    </x-slot>
    <form method="POST" action="{{ route('journal-entries.store.from-nutrients') }}">
        @csrf
        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0 w-full mb-4">
            <!-- Date -->
            <div class="w-full sm:w-auto">
                <x-inputs.label for="date" value="Date"/>

                <x-inputs.input name="date"
                                type="date"
                                class="block w-full"
                                :value="old('date', $default_date->toDateString())"
                                required />
            </div>

            <!-- Meal -->
            <div class="w-full sm:w-auto">
                <x-inputs.label for="meal" value="Meal"/>

                <x-inputs.select name="meal"
                                 class="block w-full"
                                 :options="$meals"
                                 :selectedValue="old('meal')"
                                 required>
                    <option value=""></option>
                </x-inputs.select>
            </div>

            <!-- Summary -->
            <div class="flex-auto">
                <x-inputs.label for="summary" value="Summary"/>

                <x-inputs.input name="summary"
                                type="text"
                                class="block w-full"
                                :value="old('summary')"
                                required />
            </div>
        </div>

        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0 w-full">
        @foreach (\App\Support\Nutrients::all()->sortBy('weight') as $nutrient)
            <!-- {{ ucfirst($nutrient['value']) }} -->
                <div class="flex-auto">
                    <x-inputs.label for="{{ $nutrient['value'] }}"
                                    :value="ucfirst($nutrient['value']) . ($nutrient['unit'] ? ' (' . $nutrient['unit'] . ')' : '')"/>

                    <x-inputs.input id="{{ $nutrient['value'] }}"
                                    class="block w-full"
                                    type="number"
                                    step="any"
                                    name="{{ $nutrient['value'] }}"
                                    :value="old($nutrient['value'])"/>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inputs.button class="ml-3">Add Entry</x-inputs.button>
        </div>
    </form>
</x-app-layout>
