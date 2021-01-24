<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($recipe->exists ? "Edit {$recipe->name}" : 'Add Recipe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ ($recipe->exists ? route('recipes.update', $recipe) : route('recipes.store')) }}">
                    @if ($recipe->exists)@method('put')@endif
                    @csrf
                        <div class="flex flex-col space-y-4">
                            <div class="grid grid-cols-5 gap-4">
                                <!-- Name -->
                                <div class="col-span-4">
                                    <x-inputs.label for="name" :value="__('Name')" />

                                    <x-inputs.input id="name"
                                                    class="block mt-1 w-full"
                                                    type="text"
                                                    name="name"
                                                    :value="old('name', $recipe->name)"
                                                    required />
                                </div>

                                <!-- Servings -->
                                <div>
                                    <x-inputs.label for="servings" :value="__('Servings')" />

                                    <x-inputs.input id="servings"
                                                    class="block mt-1 w-full"
                                                    type="number"
                                                    name="servings"
                                                    :value="old('servings', $recipe->servings)"
                                                    required />
                                </div>
                            </div>

                            <!-- Source -->
                            <div>
                                <x-inputs.label for="source" :value="__('Source')" />

                                <x-inputs.input id="source"
                                                class="block mt-1 w-full"
                                                type="text"
                                                name="source"
                                                :value="old('source', $recipe->source)" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-inputs.label for="description" :value="__('Description')" />

                                <x-inputs.textarea id="description"
                                                   class="block mt-1 w-full"
                                                   name="description"
                                                   :value="old('description', $recipe->description)" />
                            </div>

                            <!-- Tags -->
                            <x-tagger :defaultTags="$recipe->tags->pluck('name')"/>
                        </div>

                        <!-- Ingredients -->
                        <h3 class="pt-2 mb-2 font-extrabold">Ingredients</h3>
                        <div x-data="{ ingredients: 0 }">
                            @foreach($ingredients as $ingredient)
                                @include('recipes.partials.ingredient-input', $ingredient)
                            @endforeach
                            <template x-for="i in ingredients + 1">
                                @include('recipes.partials.ingredient-input')
                            </template>
                            <x-inputs.icon-button type="button" color="green" x-on:click="ingredients++;">
                                <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                            </x-inputs.icon-button>
                        </div>

                        <!-- Steps -->
                        <h3 class="pt-2 mb-2 font-extrabold">Steps</h3>
                        <div x-data="{ steps: 0 }">
                            @foreach($steps as $step)
                                @include('recipes.partials.step-input', $step)
                            @endforeach
                            <template x-for="i in steps + 1">
                                @include('recipes.partials.step-input')
                            </template>
                            <x-inputs.icon-button type="button" color="green" x-on:click="steps++;">
                                <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                            </x-inputs.icon-button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-inputs.button class="ml-3">
                                {{ ($recipe->exists ? 'Save' : 'Add') }}
                            </x-inputs.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
