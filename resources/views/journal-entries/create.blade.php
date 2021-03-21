<x-app-layout>
    <x-slot name="title">Add Entries</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Add Entries</h1>
            <a href="{{ route('journal-entries.create.from-nutrients', ['date' => $default_date->format('Y-m-d')]) }}" class="inline-flex items-center rounded-md font-semibold text-white p-2 bg-green-500 tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-600 disabled:opacity-25 transition ease-in-out duration-150">
                Add by Nutrients
            </a>
        </div>
    </x-slot>
    <form method="POST" action="{{ route('journal-entries.store') }}">
        @csrf
        <div x-data x-init="initJournalEntries($el);" class="space-y-4">
            @foreach($ingredients as $ingredient)
                @include('journal-entries.partials.entry-item-input', $ingredient)
            @endforeach
            <div class="journal-entry-template hidden">
                @include('journal-entries.partials.entry-item-input', ['default_date' => $default_date])
            </div>
            <x-inputs.icon-button type="button" color="green" class="add-entry-item" x-on:click="addEntryNode($el);">
                <svg class="h-10 w-10 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
            </x-inputs.icon-button>
            <div class="flex items-center justify-end mt-4 space-x-4">
                <fieldset class="flex space-x-2">
                    <x-inputs.label for="groupEntries" value="Group entries by day and meal" />
                    <x-inputs.input type="checkbox" name="group_entries" value="1" checked />
                </fieldset>
                <x-inputs.button x-on:click="removeTemplate($el);">Add entries</x-inputs.button>
            </div>
        </div>
    </form>

    @once
        @push('scripts')
            <script type="text/javascript">
                /**
                 * Adds an initial journal entry line.
                 *
                 * Add decision is based on number of direct descendent divs --
                 * there should be two (the template and the add button) if no
                 * journal entry lines have been added.
                 *
                 * @param {object} $el Journal entry lines parent element.
                 */
                let initJournalEntries = ($el) => {
                    if ($el.querySelectorAll(':scope > div').length === 2) {
                        addEntryNode($el);
                    }
                }

                /**
                 * Adds a set of entry line form fields from the template.
                 *
                 * @param {object} $el Journal entry lines parent element.
                 */
                let addEntryNode = ($el) => {
                    // Create clone of template entry.
                    let template = $el.querySelector(':scope .journal-entry-template');
                    let newEntry = template.cloneNode(true).firstElementChild;

                    // Set new entry's date and meal from the previous element.
                    let previousEntry = template.previousElementSibling;
                    if (previousEntry) {
                        let newEntryDate = newEntry.querySelector(':scope input[name="ingredients[date][]"]');
                        let newEntryMeal = newEntry.querySelector(':scope select[name="ingredients[meal][]"]');
                        let previousDate = previousEntry.querySelector(':scope input[name="ingredients[date][]"]');
                        let previousMeal = previousEntry.querySelector(':scope select[name="ingredients[meal][]"]');
                        if (newEntryDate && newEntryMeal && previousDate && previousMeal) {
                            newEntryDate.value = previousDate.value;
                            newEntryMeal.value = previousMeal.value;
                        }
                    }

                    // Insert new entry before add button.
                    $el.insertBefore(newEntry, template);
                }

                /**
                 * Removes the hidden template before form submit.
                 *
                 * This is necessary because the template has required fields.
                 *
                 * @param {object} $el Journal entry lines parent element.
                 */
                let removeTemplate = ($el) => {
                    const form = $el.closest('form');
                    const template = $el.querySelector(':scope .journal-entry-template');
                    template.remove();

                    // Re-add the template if the form is not valid without it.
                    if (!form.checkValidity()) {
                        form.querySelector(':scope .add-entry-item').before(template);
                    }
                }
            </script>
        @endpush
    @endonce

</x-app-layout>
