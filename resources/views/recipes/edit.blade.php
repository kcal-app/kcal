<x-app-layout>
    {{ $title = ($recipe->exists ? "Edit {$recipe->name}" : 'Add Recipe') }}
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $title }}</h1>
    </x-slot>
    <form method="POST" action="{{ ($recipe->exists ? route('recipes.update', $recipe) : route('recipes.store')) }}">
        @if ($recipe->exists)@method('put')@endif
        @csrf
        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
            <!-- Name -->
            <div class="flex-auto">
                <x-inputs.label for="name" value="Name" />

                <x-inputs.input name="name"
                                type="text"
                                class="block mt-1 w-full"
                                :value="old('name', $recipe->name)"
                                required />
            </div>
        </div>
        <div class="flex flex-col space-y-4 mt-4 md:flex-row md:space-x-4 md:space-y-0">
            <!-- Servings -->
            <div class="flex-auto">
                <x-inputs.label for="servings" value="Servings" />

                <x-inputs.input name="servings"
                                type="number"
                                class="block mt-1 w-full"
                                :value="old('servings', $recipe->servings)"
                                required />
            </div>

            <!-- Weight -->
            <div class="flex-auto">
                <x-inputs.label for="weight" value="Total weight (g)" />

                <x-inputs.input name="weight"
                                type="number"
                                step="any"
                                class="block mt-1 w-full"
                                :value="old('weight', $recipe->weight)" />
            </div>

            <!-- Prep Time -->
            <div class="flex-auto">
                <x-inputs.label for="time_prep" value="Prep time (minutes)" />

                <x-inputs.input name="time_prep"
                                type="number"
                                step="1"
                                min="0"
                                class="block mt-1 w-full"
                                :value="old('name', $recipe->time_prep)"/>
            </div>

            <!-- Active Time -->
            <div class="flex-auto">
                <x-inputs.label for="time_active" value="Active time (minutes)" />

                <x-inputs.input name="time_active"
                                type="number"
                                step="1"
                                min="0"
                                class="block mt-1 w-full"
                                :value="old('servings', $recipe->time_active)"/>
            </div>
        </div>
        <div class="flex flex-col space-y-4 mt-4">
            <!-- Source -->
            <div class="flex-auto">
                <x-inputs.label for="source" value="Source" />

                <x-inputs.input name="source"
                                type="text"
                                class="block mt-1 w-full"
                                :value="old('source', $recipe->source)" />
            </div>

            <!-- Description -->
            <div>
                <x-inputs.label for="description" value="Description" />

                <x-inputs.textarea name="description"
                                   class="block mt-1 w-full"
                                   :value="old('description', $recipe->description)" />
            </div>

            <!-- Tags -->
            <x-tagger :defaultTags="$recipe_tags"/>
        </div>

        <!-- Ingredients -->
        <h3 class="mt-6 mb-2 font-extrabold text-lg">Ingredients</h3>
        <div x-data class="ingredients space-y-4">
            @forelse($ingredients as $ingredient)
                @include('recipes.partials.ingredient-input', $ingredient)
            @empty
                @include('recipes.partials.ingredient-input')
            @endforelse
            <div class="entry-template hidden">
                @include('recipes.partials.ingredient-input')
            </div>
            <x-inputs.icon-button type="button" color="green" x-on:click="addEntryNode($el);">
                <svg class="h-10 w-10 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
            </x-inputs.icon-button>
        </div>

        <!-- Steps -->
        <h3 class="mt-6 mb-2 font-extrabold text-lg">Steps</h3>
        <div x-data class="steps">
            @forelse($steps as $step)
                @include('recipes.partials.step-input', $step)
            @empty
                @include('recipes.partials.step-input')
            @endforelse
            <div class="entry-template hidden">
                @include('recipes.partials.step-input')
            </div>
            <x-inputs.icon-button type="button" color="green" x-on:click="addEntryNode($el);">
                <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
            </x-inputs.icon-button>
        </div>

        <div x-data class="flex items-center justify-end mt-4">
            <x-inputs.button x-on:click="removeTemplates();" class="ml-3">
                {{ ($recipe->exists ? 'Save' : 'Add') }}
            </x-inputs.button>
        </div>
    </form>

    @once
        @push('scripts')
            <script src="{{ asset('js/recipes/edit.js') }}"></script>
            <script type="text/javascript">
                new Draggable.Sortable(document.querySelector('.ingredients'), {
                    draggable: '.ingredient',
                    handle: '.draggable-handle',
                    mirror: {
                        appendTo: '.ingredients',
                        constrainDimensions: true,
                    },
                })

                new Draggable.Sortable(document.querySelector('.steps'), {
                    draggable: '.step',
                    handle: '.draggable-handle',
                    mirror: {
                        appendTo: '.steps',
                        constrainDimensions: true,
                    },
                })
            </script>
            <script type="text/javascript">
                /**
                 * Adds a set of entry form fields from the template.
                 *
                 * @param {object} $el Entry lines parent element.
                 */
                let addEntryNode = ($el) => {
                    // Create clone of template entry.
                    let template = $el.querySelector(':scope .entry-template');
                    let newEntry = template.cloneNode(true).firstElementChild;

                    // Insert new entry before add button.
                    $el.insertBefore(newEntry, template);
                }

                /**
                 * Removes any hidden templates before form submit.
                 */
                let removeTemplates = () => {
                    document.querySelectorAll(':scope .entry-template').forEach(e => e.remove());
                }
            </script>
        @endpush
    @endonce
</x-app-layout>
