<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Nutrient Journal Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('journal-entries.store.from-nutrients') }}">
                    @csrf
                        <div class="flex mb-4 space-x-4">
                            <!-- Date -->
                            <div>
                                <x-inputs.label for="date" value="Date"/>

                                <x-inputs.input name="date"
                                                type="date"
                                                class="block mt-1"
                                                :value="old('date', \Illuminate\Support\Carbon::now()->toDateString())"
                                                required />
                            </div>

                            <!-- Meal -->
                            <div>
                                <x-inputs.label for="meal" value="Meal"/>

                                <x-inputs.select name="meal"
                                                 class="block mt-1"
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
                                                class="block mt-1 w-full"
                                                :value="old('summary')"
                                                required />
                            </div>
                        </div>

                        <div class="flex flex-auto">
                        @foreach (\App\Support\Nutrients::$all as $nutrient)
                            <!-- {{ ucfirst($nutrient) }} -->
                                <div>
                                    <x-inputs.label for="{{ $nutrient }}"
                                                    :value="ucfirst($nutrient) . ' (g)'"/>

                                    <x-inputs.input id="{{ $nutrient }}"
                                                    class="block w-5/6 mt-1"
                                                    type="number"
                                                    step="any"
                                                    name="{{ $nutrient }}"
                                                    :value="old($nutrient)"/>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-inputs.button class="ml-3">Add Entry</x-inputs.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
