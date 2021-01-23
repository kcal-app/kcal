<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Journal Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('journal-entries.store') }}">
                    @csrf
                        <div class="flex flex-row mb-4 space-x-4">
                            <!-- Date -->
                            <div>
                                <x-inputs.label for="date" :value="__('Date')"/>

                                <x-inputs.input id="date"
                                                class="block mt-1"
                                                type="date"
                                                name="date"
                                                :value="old('date', \Illuminate\Support\Carbon::now()->toDateString())"
                                                required />
                            </div>

                            <!-- Meal -->
                            <div>
                                <x-inputs.label for="meal" :value="__('Meal')"/>

                                <x-inputs.select name="meal"
                                                 class="block mt-1"
                                                 :options="$meals"
                                                 :selectedValue="old('meal')"
                                                 required>
                                    <option value=""></option>
                                </x-inputs.select>
                            </div>
                        </div>

                        <!-- Items -->
                        <div x-data="{ ingredients: 0 }">
                            <div class="grid grid-cols-12 gap-4 items-center">
                                <x-inputs.label for="amounts" value="Amount"/>
                                <x-inputs.label for="units" value="Unit" class="col-span-2"/>
                                <x-inputs.label for="foods" value="Food or Recipe" class="col-span-8"/>
                            </div>
                            <div>
                                @foreach($ingredients as $ingredient)
                                    @include('journal-entries.partials.entry-item-input', $ingredient)
                                @endforeach
                                <template x-for="i in ingredients + 1">
                                    @include('journal-entries.partials.entry-item-input')
                                </template>
                            </div>
                            <x-inputs.icon-button type="button" color="green" x-on:click="ingredients++;">
                                <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                            </x-inputs.icon-button>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-inputs.button class="ml-3">
                                {{ __('Add') }}
                            </x-inputs.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
