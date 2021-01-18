<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($food->exists ? "Edit {$food->name}" : 'Add Food') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('message'))
                <div class="bg-green-200 border-2 border-green-600 p-2 mb-2">
                    {{ session()->get('message') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="flex flex-col space-y-2 pb-2">
                    @foreach ($errors->all() as $error)
                        <div class="bg-red-200 border-2 border-red-900 p-2">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ ($food->exists ? route('foods.update', $food) : route('foods.store')) }}">
                        @if ($food->exists)@method('put')@endif
                        @csrf
                        <div class="flex flex-col space-y-4">
                            <div class="grid grid-cols-3 gap-4">
                                <!-- Name -->
                                <div>
                                    <x-inputs.label for="name" :value="__('Name')"/>

                                    <x-inputs.input id="name"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="name"
                                                    :value="old('name', $food->name)"
                                                    required/>
                                </div>

                                <!-- Detail -->
                                <div>
                                    <x-inputs.label for="detail" :value="__('Detail')"/>

                                    <x-inputs.input id="detail"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="detail"
                                                    :value="old('detail', $food->detail)"/>
                                </div>

                                <!-- Brand -->
                                <div>
                                    <x-inputs.label for="brand" :value="__('Brand')"/>

                                    <x-inputs.input id="brand"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="brand"
                                                    :value="old('brand', $food->brand)"/>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <!-- Serving size -->
                                @php
                                if (!empty($food->serving_size)) {
                                  $old_value = \App\Support\Number::fractionStringFromFloat($food->serving_size);
                                } else {
                                  $old_value = null;
                                }
                                @endphp
                                <div>
                                    <x-inputs.label for="serving_size" :value="__('Serving size')"/>

                                    <x-inputs.input id="serving_size"
                                                    class="block mt-1"
                                                    type="text"
                                                    name="serving_size"
                                                    size="10"
                                                    :value="old('serving_size', $old_value)"/>
                                </div>

                                <!-- Serving unit -->
                                <div>
                                    <x-inputs.label for="serving_unit" :value="__('Serving unit')"/>

                                    <x-inputs.select name="serving_unit"
                                                     :options="$serving_units"
                                                     :selectedValue="old('serving_unit', $food->serving_unit)">
                                        <option value=""></option>
                                    </x-inputs.select>
                                </div>

                                <!-- Serving weight -->
                                <div>
                                    <x-inputs.label for="serving_weight" :value="__('Serving weight (g)')"/>

                                    <x-inputs.input id="serving_weight"
                                                    class="block mt-1"
                                                    type="number"
                                                    step="any"
                                                    name="serving_weight"
                                                    size="10"
                                                    :value="old('serving_weight', $food->serving_weight)"/>
                                </div>
                            </div>

                            <div class="grid grid-rows-3 sm:grid-rows-3 md:grid-rows-2 lg:grid-rows-1 grid-flow-col">
                                @foreach ($nutrients as $nutrient)
                                        <!-- {{ ucfirst($nutrient) }} -->
                                        <div>
                                            <x-inputs.label for="{{ $nutrient }}"
                                                            :value="ucfirst($nutrient) . ' (g)'"/>

                                            <x-inputs.input id="{{ $nutrient }}"
                                                            class="block w-5/6 mt-1"
                                                            type="number"
                                                            step="any"
                                                            name="{{ $nutrient }}"
                                                            :value="old($nutrient, $food->{$nutrient})"/>
                                        </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-inputs.button class="ml-3">
                                {{ ($food->exists ? 'Save' : 'Add') }}
                            </x-inputs.button>
                            @if ($food->exists)
                                <a class="px-4 py-2 ml-4 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-red-700 active:bg-red-900 focus:outline-none"
                                    href="{{ route('foods.delete', $food) }}">Delete</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
