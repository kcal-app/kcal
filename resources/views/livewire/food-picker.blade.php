<div x-data="{isTyped: false}">
    <div>
        <div>
            <x-inputs.input type="text"
                            name="food"
                            placeholder="{{__('Search ...')}}"
                            x-on:input.debounce.400ms="isTyped = ($event.target.value != '')"
                            x-on:focusout="isTyped = false; $event.target.value = ''"
                            autocomplete="off"
                            wire:model.debounce.500ms="term"
                            aria-label="Search input" />
        </div>
        <div x-show="isTyped" x-cloak>
            <div class="absolute border-2 border-gray-500 border-b-0 bg-white">
                @forelse($foods as $food)
                    <div class="p-1 border-b-2 border-gray-500 hover:bg-yellow-300 cursor-pointer">
                        <div class="text">
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
                @empty
                    <div class="border-b-2 border-gray-500" x-cloak>
                        No results found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
