<div class="step">
    <x-inputs.input type="hidden" name="steps[original_key][]" :value="$original_key ?? null" />
    <div class="flex flex-row mb-4 space-x-4">
        <div class="draggable-handle self-center text-gray-500 bg-gray-100 p-2 cursor-move">
            <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
        </div>
        <x-inputs.textarea class="block mt-1 w-full" name="steps[step][]" :value="$step_default ?? null" />
        <x-inputs.icon-button type="button" color="red" x-on:click="$event.target.parentNode.remove();">
            <svg class="h-8 w-8 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </x-inputs.icon-button>
    </div>
</div>
