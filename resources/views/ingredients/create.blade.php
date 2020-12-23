<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Ingredient') }}
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
                    <form method="POST" action="{{ route('ingredients.store') }}">
                    @csrf
                        <div class="flex flex-col space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Name -->
                                <div>
                                    <x-label for="name" :value="__('Name')" />

                                    <x-input id="name"
                                             class="block mt-1 w-full"
                                             type="text"
                                             name="name"
                                             :value="old('name')"
                                             required />
                                </div>

                                <!-- Detail -->
                                <div>
                                    <x-label for="detail" :value="__('Detail')" />

                                    <x-input id="detail"
                                             class="block mt-1 w-full"
                                             type="text"
                                             name="detail"
                                             :value="old('detail')" />
                                </div>
                            </div>

                            <div class="grid grid-rows-3 md:grid-rows-2 lg:grid-rows-1 grid-flow-col">
                                <!-- Calories -->
                                <div>
                                    <x-label for="calories" :value="__('Calories')" />

                                    <x-input id="calories"
                                             class="block mt-1"
                                             type="number"
                                             step="any"
                                             name="calories"
                                             size="10"
                                             :value="old('calories')" />
                                </div>

                                <!-- Carbohydrates -->
                                <div>
                                    <x-label for="carbohydrates" :value="__('Carbohydrates')" />

                                    <x-input id="carbohydrates"
                                             class="block mt-1"
                                             type="number"
                                             step="any"
                                             name="carbohydrates"
                                             size="10"
                                             :value="old('carbohydrates')" />
                                </div>

                                <!-- Cholesterol -->
                                <div>
                                    <x-label for="cholesterol" :value="__('Cholesterol')" />

                                    <x-input id="cholesterol"
                                             class="block mt-1"
                                             type="number"
                                             step="any"
                                             name="cholesterol"
                                             size="10"
                                             :value="old('cholesterol')" />
                                </div>

                                <!-- Fat -->
                                <div>
                                    <x-label for="fat" :value="__('Fat')" />

                                    <x-input id="fat"
                                             class="block mt-1"
                                             type="number"
                                             step="any"
                                             name="fat"
                                             size="10"
                                             :value="old('fat')" />
                                </div>

                                <!-- Protein -->
                                <div>
                                    <x-label for="protein" :value="__('Protein')" />

                                    <x-input id="protein"
                                             class="block mt-1"
                                             type="number"
                                             step="any"
                                             name="protein"
                                             size="10"
                                             :value="old('protein')" />
                                </div>

                                <!-- Sodium -->
                                <div>
                                    <x-label for="sodium" :value="__('Sodium')" />

                                    <x-input id="sodium"
                                             class="block mt-1"
                                             type="number"
                                             step="any"
                                             name="sodium"
                                             size="10"
                                             :value="old('sodium')" />
                                </div>
                            </div>

                            <div class="flex items-center">
                                <!-- Cup weight -->
                                <div>
                                    <x-label for="cup_weight" :value="__('Cup weight')" />

                                    <x-input id="cup_weight"
                                             class="block mt-1"
                                             type="number"
                                             step="any"
                                             name="cup_weight"
                                             size="10"
                                             :value="old('cup_weight')" />
                                </div>

                                <div class="p-4 font-black text-3xl">
                                    or
                                </div>

                                <!-- Unit weight -->
                                <div>
                                    <x-label for="unit_weight" :value="__('Unit weight')" />

                                    <x-input id="unit_weight"
                                             class="block mt-1"
                                             type="number"
                                             step="any"
                                             name="unit_weight"
                                             size="10"
                                             :value="old('unit_weight')" />
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Add') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
