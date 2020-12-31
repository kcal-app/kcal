<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Food') }}
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
                    <form method="POST" action="{{ route('foods.store') }}">
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
                                                    :value="old('name')"
                                                    required/>
                                </div>

                                <!-- Detail -->
                                <div>
                                    <x-inputs.label for="detail" :value="__('Detail')"/>

                                    <x-inputs.input id="detail"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="detail"
                                                    :value="old('detail')"/>
                                </div>

                                <!-- Brand -->
                                <div>
                                    <x-inputs.label for="brand" :value="__('Brand')"/>

                                    <x-inputs.input id="brand"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="brand"
                                                    :value="old('brand')"/>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <!-- Serving size -->
                                <div>
                                    <x-inputs.label for="serving_size" :value="__('Serving size')"/>

                                    <x-inputs.input id="serving_size"
                                                    class="block mt-1"
                                                    type="number"
                                                    step="any"
                                                    name="serving_size"
                                                    size="10"
                                                    :value="old('serving_size')"/>
                                </div>

                                <!-- Serving unit -->
                                <div>
                                    <x-inputs.label for="serving_unit" :value="__('Serving unit')"/>

                                    <x-inputs.select name="serving_unit"
                                                     :options="$serving_units"
                                                     :selectedValue="old('serving_unit')">
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
                                                    :value="old('serving_weight')"/>
                                </div>
                            </div>

                            <div class="grid grid-rows-3 md:grid-rows-2 lg:grid-rows-1 grid-flow-col">
                                <!-- Calories -->
                                <div>
                                    <x-inputs.label for="calories" :value="__('Calories (g)')"/>

                                    <x-inputs.input id="calories"
                                                    class="block mt-1"
                                                    type="number"
                                                    step="any"
                                                    name="calories"
                                                    size="10"
                                                    :value="old('calories')"/>
                                </div>

                                <!-- Fat -->
                                <div>
                                    <x-inputs.label for="fat" :value="__('Fat (g)')"/>

                                    <x-inputs.input id="fat"
                                                    class="block mt-1"
                                                    type="number"
                                                    step="any"
                                                    name="fat"
                                                    size="10"
                                                    :value="old('fat')"/>
                                </div>

                                <!-- Cholesterol -->
                                <div>
                                    <x-inputs.label for="cholesterol" :value="__('Cholesterol (g)')"/>

                                    <x-inputs.input id="cholesterol"
                                                    class="block mt-1"
                                                    type="number"
                                                    step="any"
                                                    name="cholesterol"
                                                    size="10"
                                                    :value="old('cholesterol')"/>
                                </div>

                                <!-- Sodium -->
                                <div>
                                    <x-inputs.label for="sodium" :value="__('Sodium (g)')"/>

                                    <x-inputs.input id="sodium"
                                                    class="block mt-1"
                                                    type="number"
                                                    step="any"
                                                    name="sodium"
                                                    size="10"
                                                    :value="old('sodium')"/>
                                </div>

                                <!-- Carbohydrates -->
                                <div>
                                    <x-inputs.label for="carbohydrates" :value="__('Carbohydrates (g)')"/>

                                    <x-inputs.input id="carbohydrates"
                                                    class="block mt-1"
                                                    type="number"
                                                    step="any"
                                                    name="carbohydrates"
                                                    size="10"
                                                    :value="old('carbohydrates')"/>
                                </div>

                                <!-- Protein -->
                                <div>
                                    <x-inputs.label for="protein" :value="__('Protein (g)')"/>

                                    <x-inputs.input id="protein"
                                                    class="block mt-1"
                                                    type="number"
                                                    step="any"
                                                    name="protein"
                                                    size="10"
                                                    :value="old('protein')"/>
                                </div>
                            </div>
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
