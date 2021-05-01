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
                <!-- From -->
                <div class="flex-auto">
                    <x-inputs.label for="from" value="From"/>
                    <x-inputs.input name="from"
                                    type="date"
                                    class="block w-full"
                                    :value="old('from', $goal->from?->toDateString())"
                                    :hasError="$errors->has('from')" />
                </div>

                <!-- To -->
                <div class="flex-auto">
                    <x-inputs.label for="to" value="To"/>
                    <x-inputs.input name="to"
                                    type="date"
                                    class="block w-full"
                                    :value="old('to', $goal->to?->toDateString())"
                                    :hasError="$errors->has('to')" />
                </div>

                <!-- Goal -->
                <div class="flex-auto">
                    <x-inputs.label for="goal" value="Goal" />
                    <x-inputs.input name="goal"
                                    type="number"
                                    step="any"
                                    class="block w-full"
                                    :value="old('goal', $goal->goal)"
                                    :hasError="$errors->has('goal')"
                                    required />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inputs.button class="ml-3">
                {{ ($goal->exists ? 'Save' : 'Add') }}
            </x-inputs.button>
        </div>
    </form>
</x-app-layout>
