<x-app-layout>
    @php($title = ($goal->exists ? 'Edit' : 'Add') . ' Goal')
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $title }}</h1>
    </x-slot>
    <form method="POST" action="{{ ($goal->exists ? route('goals.update', $goal) : route('goals.store')) }}">
        @if ($goal->exists)@method('put')@endif
        @csrf
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                <!-- Name -->
                <div class="flex-auto">
                    <x-inputs.label for="name" value="Name" />

                    <x-inputs.input name="name"
                                    type="text"
                                    class="block mt-1 w-full"
                                    :value="old('name', $goal->name)"
                                    required />
                </div>
            </div>
            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                <!-- Days of the week -->
                <fieldset>
                    <legend class="block font-medium text-sm text-gray-700">Days of the week</legend>
                    <div class="flex flex-col justify-content divide-x border rounded-md shadow-sm border-gray-300 md:inline-flex md:flex-row">
                        @foreach(\App\Models\Goal::days() as $day)
                            <x-inputs.label class="inline-flex justify-center p-2">
                                <x-inputs.input type="checkbox" name="days[]" :value="$day['value']" :checked="($goal->days & $day['value']) != 0" />
                                <span class="ml-2">{{ \Illuminate\Support\Str::ucfirst($day['label']) }}</span>
                            </x-inputs.label>
                        @endforeach
                    </div>
                </fieldset>
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
                                        :value="old($nutrient['value'], $goal->{$nutrient['value']})"
                                        :hasError="$errors->has($nutrient['value'])"/>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inputs.button class="ml-3">
                {{ ($goal->exists ? 'Save' : 'Add') }}
            </x-inputs.button>
        </div>
    </form>
</x-app-layout>
