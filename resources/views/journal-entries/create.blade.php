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
                        <div class="grid grid-cols-12 gap-4 items-center">
                            <x-inputs.label for="amounts" :value="__('Amount')"/>
                            <x-inputs.label for="units" :value="__('Unit')" class="col-span-2"/>
                            <x-inputs.label for="foods" :value="__('Food')" class="col-span-4"/>
                            <div class="text-center">- or -</div>
                            <x-inputs.label for="recipes" :value="__('Recipe')" class="col-span-4"/>
                            @for ($i = 0; $i < 10; $i++)
                                <div>
                                    <x-inputs.input type="text"
                                                    name="amounts[]"
                                                    class="block w-full"
                                                    :value="old('amounts.' . $i)" />
                                </div>
                                <div class="col-span-2">
                                    <x-inputs.select name="units[]"
                                                     class="block w-full"
                                                     :options="$units"
                                                     :selectedValue="old('units.' . $i)">
                                        <option value=""></option>
                                    </x-inputs.select>
                                </div>
                                <div class="col-span-4">
                                    <x-inputs.select name="foods[]"
                                                     class="block w-full"
                                                     :options="$foods"
                                                     :selectedValue="old('foods.' . $i)">
                                        <option value=""></option>
                                    </x-inputs.select>
                                </div>
                                <div class="text-center">- or -</div>
                                <div class="col-span-4">
                                    <x-inputs.select name="recipes[]"
                                                     class="block w-full"
                                                     :options="$recipes"
                                                     :selectedValue="old('recipes.' . $i)">
                                        <option value=""></option>
                                    </x-inputs.select>
                                </div>
                            @endfor
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
