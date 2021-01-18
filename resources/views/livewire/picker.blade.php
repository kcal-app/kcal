<div x-data="{isTyped: false}">
    <div>
        <div>
            <x-inputs.input type="text"
                            name="picker"
                            placeholder="{{__('Search ...')}}"
                            x-on:input.debounce.400ms="isTyped = ($event.target.value != '')"
                            autocomplete="off"
                            wire:model.debounce.500ms="term"
                            aria-label="Search input" />
        </div>
        <!-- TODO: Implement as a library like Select2 or Chosen. -->
        <div x-show="isTyped" x-cloak>
            <div class="absolute bg-white">
                @forelse($results as $result)
                    <div class="p-1 hover:bg-yellow-300 cursor-pointer">
                        <ul>
                            <li>
                                {{ Str::limit($result->name, 40) }}
                            </li>
                        </ul>
                    </div>
                @empty
                    <div x-cloak>
                        No results found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
