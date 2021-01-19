<div x-data="{searching: false}">
    <div>
        <div>
            <x-inputs.input type="hidden"
                            name="foods[{{ $index }}]"
                            :value="$defaultId"
                            x-ref="foods{{ $index }}"/>
            <x-inputs.input type="text"
                            name="foods_name[{{ $index }}]"
                            :value="$defaultName"
                            placeholder="Search..."
                            autocomplete="off"
                            wire:model.debounce.500ms="term"
                            x-on:input.debounce.400ms="searching = ($event.target.value != '')"
                            x-on:focusout.debounce.200ms="searching = false;"
                            x-ref="foods_name{{ $index }}" />
        </div>
        <div x-show="searching" x-cloak>
            <div class="absolute border-2 border-gray-500 border-b-0 bg-white"
                 x-on:click="selected = $event.target; if (selected.dataset.id) { $refs.foods_name{{ $index }}.value = selected.dataset.value; $refs.foods{{ $index }}.value = selected.dataset.id; searching = false; }">
                @forelse($foods as $food)
                    <div class="p-1 border-b-2 border-gray-500 hover:bg-yellow-300 cursor-pointer"
                         wire:key="{{ $food->id }}"
                         data-id="{{ $food->id }}"
                         data-value="{{ $food->name }}">
                        <div class="pointer-events-none">
                            <div>
                                {{ $food->name }}@if($food->detail), <span class="text-gray-500">{{ $food->detail }}</span>@endif
                            </div>
                            @if($food->brand)
                                <div class="text-sm text-gray-600">
                                    {{ $food->brand }}
                                </div>
                            @endif
                            <div class="text-sm">
                                Serving size {{ \App\Support\Number::fractionStringFromFloat($food->serving_size) }}
                                {{ $food->serving_unit }}
                                ({{ $food->serving_weight }}g)
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-1 border-b-2 border-gray-500" x-cloak>
                        No results found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
