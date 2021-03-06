<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($food->exists ? "Edit {$food->name}" : 'Add Food') }}
        </h2>
    </x-slot>
    <form method="POST" action="{{ ($food->exists ? route('foods.update', $food) : route('foods.store')) }}">
                        @if ($food->exists)@method('put')@endif
                        @csrf
                        <div class="flex flex-col space-y-4">
                            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                                <!-- Name -->
                                <div class="flex-auto">
                                    <x-inputs.label for="name" value="Name"/>

                                    <x-inputs.input id="name"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="name"
                                                    :value="old('name', $food->name)"
                                                    required/>
                                </div>

                                <!-- Detail -->
                                <div class="flex-auto">
                                    <x-inputs.label for="detail" value="Detail"/>

                                    <x-inputs.input id="detail"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="detail"
                                                    :value="old('detail', $food->detail)"/>
                                </div>

                                <!-- Brand -->
                                <div class="flex-auto">
                                    <x-inputs.label for="brand" value="Brand"/>

                                    <x-inputs.input id="brand"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="brand"
                                                    :value="old('brand', $food->brand)"/>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                                <!-- Serving size -->
                                @php
                                if (!empty($food->serving_size)) {
                                  $old_value = \App\Support\Number::fractionStringFromFloat($food->serving_size);
                                } else {
                                  $old_value = null;
                                }
                                @endphp
                                <div>
                                    <x-inputs.label for="serving_size" value="Serving size"/>

                                    <x-inputs.input id="serving_size"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="serving_size"
                                                    size="10"
                                                    :value="old('serving_size', $old_value)"
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
                                                    placeholder="e.g. clove, egg"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    size="10"
                                                    :value="old('serving_unit_name', $food->serving_unit_name)"/>
                                </div>

                                <!-- Serving weight -->
                                <div>
                                    <x-inputs.label for="serving_weight" value="Serving weight (g)"/>

                                    <x-inputs.input id="serving_weight"
                                                    class="block mt-1 w-full"
                                                    type="number"
                                                    step="any"
                                                    name="serving_weight"
                                                    size="10"
                                                    :value="old('serving_weight', $food->serving_weight)"
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
                                                            class="block w-full mt-1 md:w-5/6"
                                                            step="any"
                                                            :value="old($nutrient['value'], $food->{$nutrient['value']})"/>
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
