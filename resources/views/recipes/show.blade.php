<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $recipe->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="mb-2 font-bold">Description</h3>
                    <div class="text-gray-800">{{ $recipe->description }}</div>
                    <h3 class="mb-2 mt-4 font-bold">Ingredients</h3>
                    @foreach($recipe->foodAmounts as $ia)
                        <div class="flex flex-row space-x-2 mb-2">
                            <div>{{ $ia->amount }}</div>
                            @if($ia->unit)<div>{{ $ia->unit }}</div>@endif
                            <div>{{ $ia->food->name }}</div>
                        </div>
                    @endforeach
                    <h3 class="mb-2 mt-4 font-bold">Steps</h3>
                    @foreach($recipe->steps as $step)
                        <div class="flex flex-row space-x-4 mb-4">
                            <div class="text-3xl text-gray-400 text-center">{{ $step->number }}</div>
                            <div class="text-2xl">{{ $step->step }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
