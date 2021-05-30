<x-app-layout>
    <x-slot name="title">Add Entry</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Add Entry</h1>
            <x-button-link.green href="{{ route('journal-entries.create', ['date' => $default_date->format('Y-m-d')]) }}" class="text-sm">
                Add by Recipes/Foods
            </x-button-link.green>
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
                                :hasError="$errors->has('date')"
                                required />
            </div>

            <!-- Meal -->
            <div class="w-full sm:w-auto">
                <x-inputs.label for="meal" value="Meal"/>

                <x-inputs.select name="meal"
                                 class="block w-full"
                                 :options="Auth::user()->meals->where('enabled', true)->sortBy('weight')->toArray()"
                                 :selectedValue="old('meal')"
                                 :hasError="$errors->has('meal')"
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
                                :hasError="$errors->has('summary')"
                                required />
            </div>
        </div>

        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0 w-full">
        @foreach (\App\Support\Nutrients::all()->sortBy('weight') as $nutrient)
            <!-- {{ ucfirst($nutrient['value']) }} -->
                <div class="flex-auto">
                    <x-inputs.label for="{{ $nutrient['value'] }}"
                                    :value="ucfirst($nutrient['value']) . ($nutrient['unit'] ? ' (' . $nutrient['unit'] . ')' : '')"/>

                    <x-inputs.input name="{{ $nutrient['value'] }}"
                                    type="number"
                                    step="any"
                                    class="block w-full"
                                    :value="old($nutrient['value'])"
                                    :hasError="$errors->has($nutrient['value'])"/>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inputs.button class="ml-3">Add Entry</x-inputs.button>
        </div>
    </form>
</x-app-layout>
