<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($recipe->exists ? "Edit {$recipe->name}" : 'Add Recipe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ ($recipe->exists ? route('recipes.update', $recipe) : route('recipes.store')) }}">
                    @if ($recipe->exists)@method('put')@endif
                    @csrf
                        <div class="flex flex-col space-y-4">
                            <div class="grid grid-cols-5 gap-4">
                                <!-- Name -->
                                <div class="col-span-4">
                                    <x-inputs.label for="name" :value="__('Name')" />

                                    <x-inputs.input id="name"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="name"
                                                    :value="old('name', $recipe->name)"
                                                    required />
                                </div>

                                <!-- Servings -->
                                <div>
                                    <x-inputs.label for="servings" :value="__('Servings')" />

                                    <x-inputs.input id="servings"
                                                    class="block mt-1 w-full"
                                                    type="number"
                                                    name="servings"
                                                    :value="old('servings', $recipe->servings)"
                                                    required />
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <x-inputs.label for="description" :value="__('Description')" />

                                <x-inputs.textarea id="description"
                                                   class="block mt-1 w-full"
                                                   name="description"
                                                   :value="old('description', $recipe->description)" />
                            </div>

                            <!-- Source -->
                            <div>
                                <x-inputs.label for="source" :value="__('Source')" />

                                <x-inputs.input id="source"
                                                class="block mt-1 w-full"
                                                type="text"
                                                name="source"
                                                :value="old('source', $recipe->source)" />
                            </div>
                        </div>

                        <!-- Ingredients -->
                        <h3 class="pt-2 mb-2 font-extrabold">Ingredients</h3>
                        <div x-data="{ingredients: 0}">
                            @foreach($recipe->foodAmounts as $foodAmount)
                                <div class="flex flex-row space-x-4 mb-4">
                                    <x-inputs.input type="text"
                                                    name="foods_amount[]"
                                                    size="5"
                                                    :value="old('foods_amount.' . $loop->index, \App\Support\Number::fractionStringFromFloat($foodAmount->amount))" />
                                    <x-inputs.select name="foods_unit[]"
                                                     :options="$food_units"
                                                     :selectedValue="old('foods_unit.' . $loop->index, $foodAmount->unit)">
                                        <option value=""></option>
                                    </x-inputs.select>
                                    <livewire:food-picker :index="$loop->index"
                                                          :default-id="old('foods.' . $loop->index, $foodAmount->food->id)"
                                                          :default-name="old('foods_name.' . $loop->index, $foodAmount->food->name)" />
                                    <x-inputs.input type="text"
                                                    class="block"
                                                    name="foods_detail[]"
                                                    :value="old('foods_detail.' . $loop->index, $foodAmount->detail)" />
                                </div>
                            @endforeach
                            <template x-for="i in ingredients + 1">
                                <div class="flex flex-row space-x-4 mb-4">
                                    <x-inputs.input type="text"
                                                    name="foods_amount[]"
                                                    size="5" />
                                    <x-inputs.select name="foods_unit[]"
                                                     :options="$food_units" >
                                        <option value=""></option>
                                    </x-inputs.select>
                                    <!-- TODO: Get this working in the template. See wire:init or use wire:click? -->
                                    <livewire:food-picker index="1" />
                                    <x-inputs.input type="text"
                                                    class="block"
                                                    name="foods_detail[]" />
                                </div>
                            </template>
                            <x-inputs.button type="button" class="ml-3" x-on:click="ingredients++;">
                                Add Ingredient
                            </x-inputs.button>
                        </div>

                        <!-- Steps -->
                        <h3 class="pt-2 mb-2 font-extrabold">Steps</h3>
                        @php($step_number = 0)
                        <div x-data="{steps: 0}">
                            @foreach($recipe->steps as $step)
                                <div class="flex flex-row space-x-4 mb-4">
                                    <div class="text-3xl text-gray-400 text-center">{{ $step_number++ }}</div>
                                    <x-inputs.textarea class="block mt-1 w-full"
                                                       name="steps[]"
                                                       :value="old('steps.' . $loop->index, $step->step)" />
                                </div>
                            @endforeach
                            <template x-for="i in steps + 1">
                                <div class="flex flex-row space-x-4 mb-4">
                                    <div class="text-3xl text-gray-400 text-center" x-text="{{ $step_number }} + i"></div>
                                    <x-inputs.textarea class="block mt-1 w-full"
                                                       name="steps[]" />
                                </div>
                            </template>
                            <x-inputs.button type="button" class="ml-3" x-on:click="steps++;">
                                Add Step
                            </x-inputs.button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-inputs.button class="ml-3">
                                {{ ($recipe->exists ? 'Save' : 'Add') }}
                            </x-inputs.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
