<x-app-layout>
    <x-slot name="title">My Meals</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">My Meals</h1>
    </x-slot>
    <form method="POST" enctype="multipart/form-data" action="{{ route('meals.update') }}">
        @method('put')
        @csrf
        <div class="flex flex-col space-y-4">
            <div x-data class="meals space-y-4">
            @foreach($meals as $key => $meal)
                <div class="meal draggable w-full">
                    <x-inputs.input type="hidden" name="meal[value][]" :value="$key" />
                    <x-inputs.input type="hidden" name="meal[weight][]" :value="$meal['weight'] ?? null" />
                    <div class="flex flex-row space-x-4 w-full items-center">
                        <div class="draggable-handle self-center text-gray-500 bg-gray-100 w-auto p-2 cursor-move">
                            <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-inputs.input name="meal[label][]"
                                        type="text"
                                        size="5"
                                        placeholder="Breakfast, lunch, dinner, etc."
                                        class="block w-full"
                                        :value="$meal['label'] ?? null" />
                        <x-inputs.input type="checkbox" name="meal[enabled][]" value="1" checked="checked" />
                    </div>
                </div>
            @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inputs.button>Save</x-inputs.button>
        </div>
    </form>

    @once
        @push('scripts')
            <script src="{{ asset('js/draggable.js') }}"></script>
            <script type="text/javascript">
                // Activate meals sortable.
                const mealsSortable = new Draggable.Sortable(document.querySelector('.meals'), {
                    draggable: '.draggable',
                    handle: '.draggable-handle',
                    mirror: {
                        appendTo: '.meals',
                        constrainDimensions: true,
                    },
                })

                // Recalculate weight (order) of all ingredients.
                mealsSortable.on('drag:stopped', (e) => {
                    Array.from(e.sourceContainer.children)
                        .filter(el => el.classList.contains('draggable'))
                        .forEach((el, index) => {
                            el.querySelector('input[name$="[weight][]"]').value = index;
                        });
                })
            </script>
        @endpush
    @endonce
</x-app-layout>
