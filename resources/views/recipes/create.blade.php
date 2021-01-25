<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Recipe</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('recipes.store') }}">
                    @csrf
                        <div class="flex flex-col space-y-4">
                            <div class="grid grid-cols-5 gap-4">
                                <!-- Name -->
                                <div class="col-span-4">
                                    <x-inputs.label for="name" value="Name" />

                                    <x-inputs.input id="name"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="name"
                                                    :value="old('name')"
                                                    required />
                                </div>

                                <!-- Servings -->
                                <div>
                                    <x-inputs.label for="servings" value="Servings" />

                                    <x-inputs.input id="servings"
                                                    class="block mt-1 w-full"
                                                    type="number"
                                                    name="servings"
                                                    :value="old('servings')"
                                                    required />
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <x-inputs.label for="description" value="Description" />

                                <x-inputs.textarea id="description"
                                                   class="block mt-1 w-full"
                                                   name="description"
                                                   :value="old('description')" />
                            </div>
                        </div>

                        <!-- Ingredients -->
                        <h3 class="pt-2 mb-2 font-extrabold">Ingredients</h3>
                        @for($i = 0; $i < 20; $i++)
                            <div class="flex flex-row space-x-4 mb-4">
                                <x-inputs.input type="text"
                                                name="foods_amount[]"
                                                size="5"
                                                :value="old('foods_amount.' . $i)" />
                                <x-inputs.select name="foods_unit[]"
                                                 :options="$food_units"
                                                 :selectedValue="old('foods_unit.' . $i)">
                                    <option value=""></option>
                                </x-inputs.select>
                                <x-inputs.select name="foods[]"
                                                 :options="$foods"
                                                 :selectedValue="old('foods.' . $i)">
                                    <option value=""></option>
                                </x-inputs.select>
                            </div>
                        @endfor

                        <!-- Steps -->
                        <h3 class="pt-2 mb-2 font-extrabold">Steps</h3>
                        @for($i = 0; $i < 20; $i++)
                            <div class="flex flex-row space-x-4 mb-4">
                                <div class="text-3xl text-gray-400 text-center">{{ $i + 1 }}</div>
                                <x-inputs.textarea class="block mt-1 w-full"
                                                   name="steps[]"
                                                   :value="old('steps.' . $i)" />
                            </div>
                        @endfor

                        <div class="flex items-center justify-end mt-4">
                            <x-inputs.button class="ml-3">Add</x-inputs.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
