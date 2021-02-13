<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($goal->exists ? 'Edit' : 'Add') }} Goal
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ ($goal->exists ? route('goals.update', $goal) : route('goals.store')) }}">
                        @if ($goal->exists)@method('put')@endif
                        @csrf
                        <div class="flex flex-col space-y-4">
                            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                                <!-- From -->
                                <div class="flex-auto">
                                    <x-inputs.label for="from" value="From"/>
                                    <x-inputs.input name="from"
                                                    type="date"
                                                    class="block w-full"
                                                    :value="old('from', $goal->from)" />
                                </div>

                                <!-- To -->
                                <div class="flex-auto">
                                    <x-inputs.label for="to" value="To"/>
                                    <x-inputs.input name="to"
                                                    type="date"
                                                    class="block w-full"
                                                    :value="old('to', $goal->to)" />
                                </div>

                                <!-- Attribute -->
                                <div class="flex-auto">
                                    <x-inputs.label for="attribute" value="Attribute"/>

                                    <x-inputs.select name="attribute"
                                                     class="block mt-1 w-full"
                                                     :options="$attributeOptions"
                                                     :selectedValue="old('attribute', $goal->attribute)">
                                        <option value=""></option>
                                    </x-inputs.select>
                                </div>

                                <!-- Goal -->
                                <div class="flex-auto">
                                    <x-inputs.label for="goal" value="Goal"/>

                                    <x-inputs.input name="goal"
                                                    type="number"
                                                    step="any"
                                                    class="block mt-1 w-full"
                                                    :value="old('goal', $goal->goal)"/>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-inputs.button class="ml-3">
                                {{ ($goal->exists ? 'Save' : 'Add') }}
                            </x-inputs.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
