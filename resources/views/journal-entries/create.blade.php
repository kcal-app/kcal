<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Journal Entries</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('journal-entries.store') }}">
                    @csrf
                        <div x-data="{ ingredients: 1 }">
                            <div class="space-y-4">
                                @foreach($ingredients as $ingredient)
                                    @include('journal-entries.partials.entry-item-input', $ingredient)
                                @endforeach
                                <template x-if="ingredients > 0" x-for="i in ingredients">
                                    @include('journal-entries.partials.entry-item-input', ['default_date' => $default_date])
                                </template>
                            </div>
                            <x-inputs.icon-button type="button" color="green" x-on:click="ingredients++;">
                                <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                            </x-inputs.icon-button>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-inputs.button class="ml-3">Add entries</x-inputs.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
