<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex flex-auto">
            {{ $recipe->name }}
            <a class="ml-2 text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm"
               href="{{ route('recipes.edit', $recipe) }}">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                </svg>
            </a>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-2 text-gray-500 text-sm">
                        <span class="font-extrabold">Source:</span>
                        {{ $recipe->source }}
                    </div>
                    <h3 class="mb-2 font-bold">Description</h3>
                    <div class="mb-2 text-gray-800">{{ $recipe->description }}</div>
                    <h3 class="mb-2 font-bold">Ingredients</h3>
                    @foreach($recipe->ingredientAmounts as $ia)
                        <div class="flex flex-row space-x-2 mb-2">
                            <div>{{ \App\Support\Number::fractionStringFromFloat($ia->amount) }}</div>
                            @if($ia->unit)<div>{{ $ia->unit }}</div>@endif
                            <div>
                                @if($ia->ingredient->type === \App\Models\Recipe::class)
                                    <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                       href="{{ route('recipes.show', $ia->ingredient) }}">
                                        {{ $ia->ingredient->name }}
                                    </a>
                                @else
                                    {{ $ia->ingredient->name }}
                                @endif
                            </div>
                            @if($ia->detail)<div class="text-gray-500">{{ $ia->detail }}</div>@endif
                        </div>
                    @endforeach
                    <h3 class="mb-2 font-bold">Steps</h3>
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
