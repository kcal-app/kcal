<x-app-layout>
    @php($title = ($food->exists ? "Edit {$food->name}" : 'Add Food'))
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $title }}</h1>
    </x-slot>
    <form method="POST" action="{{ ($food->exists ? route('foods.update', $food) : route('foods.store')) }}">
        @if ($food->exists)@method('put')@endif
        @csrf
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                <!-- Name -->
                <div class="flex-auto">
                    <x-inputs.label for="name" value="Name"/>

                    <x-inputs.input name="name"
                                    type="text"
                                    class="block mt-1 w-full"
                                    autocapitalize="none"
                                    :value="old('name', $food->name)"
                                    :hasError="$errors->has('name')"/>
                </div>

                <!-- Detail -->
                <div class="flex-auto">
                    <x-inputs.label for="detail" value="Detail"/>

                    <x-inputs.input name="detail"
                                    type="text"
                                    class="block mt-1 w-full"
                                    autocapitalize="none"
                                    :value="old('detail', $food->detail)"/>
                </div>

                <!-- Brand -->
                <div class="flex-auto">
                    <x-inputs.label for="brand" value="Brand"/>

                    <x-inputs.input name="brand"
                                    type="text"
                                    class="block mt-1 w-full"
                                    :value="old('brand', $food->brand)"/>
                </div>
            </div>

            <div class="flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                <!-- Serving size -->
                <div>
                    <x-inputs.label for="serving_size" value="Serving size"/>

                    <x-inputs.input name="serving_size"
                                    type="text"
                                    class="block mt-1 w-full"
                                    size="10"
                                    :value="old('serving_size', $food->serving_size_formatted)"
                                    :hasError="$errors->has('serving_size')"
                                    required/>
                </div>

                <!-- Serving unit -->
                <div>
                    <x-inputs.label for="serving_unit" value="Serving unit"/>

                    <x-inputs.select name="serving_unit"
                                     class="block mt-1 w-full"
                                     :options="$serving_units"
                                     :selectedValue="old('serving_unit', $food->serving_unit)">
                        <option value=""></option>
                    </x-inputs.select>
                </div>

                <!-- Serving unit name -->
                <div>
                    <x-inputs.label for="serving_unit_name" value="Serving unit name"/>

                    <x-inputs.input name="serving_unit_name"
                                    type="text"
                                    autocapitalize="none"
                                    class="block mt-1 w-full"
                                    placeholder="e.g. clove, egg"
                                    size="10"
                                    :value="old('serving_unit_name', $food->serving_unit_name)"/>
                </div>

                <!-- Serving weight -->
                <div>
                    <x-inputs.label for="serving_weight" value="Serving weight (g)"/>

                    <x-inputs.input name="serving_weight"
                                    type="number"
                                    step="any"
                                    class="block mt-1 w-full"
                                    size="10"
                                    :value="old('serving_weight', $food->serving_weight)"
                                    :hasError="$errors->has('serving_weight')"
                                    required/>
                </div>
            </div>

            <div class="flex flex-col space-y-4 md:flex-row md:space-y-0">
                @foreach (\App\Support\Nutrients::all()->sortBy('weight') as $nutrient)
                        <!-- {{ ucfirst($nutrient['value']) }} -->
                        <div class="flex-auto">
                            <x-inputs.label for="{{ $nutrient['value'] }}"
                                            :value="ucfirst($nutrient['value']) . ($nutrient['unit'] ? ' (' . $nutrient['unit'] . ')' : '')"/>

                            <x-inputs.input name="{{ $nutrient['value'] }}"
                                            type="number"
                                            step="any"
                                            class="block w-full mt-1 md:w-5/6"
                                            :value="old($nutrient['value'], $food->{$nutrient['value']})"
                                            :hasError="$errors->has($nutrient['value'])"/>
                        </div>
                @endforeach
            </div>

            <!-- Tags -->
            <x-tagger :defaultTags="$food_tags"/>

            <!-- Source -->
            <div class="flex-auto">
                <x-inputs.label for="source" value="Source" />

                <x-inputs.input name="source"
                                type="text"
                                class="block mt-1 w-full"
                                inputmode="url"
                                :value="old('source', $food->source)" />
            </div>

            <!-- Notes -->
            <div>
                <x-inputs.label for="description" value="Description" />

                <x-inputs.textarea name="notes"
                                   class="block mt-1 w-full"
                                   :value="old('notes', $food->notes)" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inputs.button class="ml-3">
                {{ ($food->exists ? 'Save' : 'Add') }}
            </x-inputs.button>
        </div>
    </form>
</x-app-layout>
