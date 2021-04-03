<div class="separator draggable">
    <x-inputs.input type="hidden" name="separators[key][]" :value="$key ?? null" />
    <x-inputs.input type="hidden" name="separators[weight][]" :value="$weight ?? null" />
    <div class="flex items-center space-x-2">
        <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0 w-full">
            <div class="draggable-handle self-center text-gray-500 bg-gray-100 w-full md:w-auto p-2 cursor-move">
                <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <x-inputs.label for="source" value="Separator text" class="hidden" />

            <x-inputs.input name="separators[text][]"
                            type="text"
                            placeholder="Separator text (optional)"
                            class="block w-full"
                            :value="$text ?? null" />
        </div>
        <div class="flex-none">
            <x-inputs.icon-red x-on:click="$event.target.parentNode.parentNode.parentNode.remove();">
                <svg class="h-8 w-8 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </x-inputs.icon-red>
        </div>
    </div>
</div>
