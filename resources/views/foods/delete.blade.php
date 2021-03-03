<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Delete {{ $food->name }}?
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('foods.destroy', $food) }}">
                        @method('delete')
                        @csrf
                        <div class="pb-3">
                            <div class="text-lg">Are you sure what to delete <span class="font-extrabold">{{ $food->name }}</span>?</div>
                            <div class="flex flex-col space-y-2 mt-2 text-lg">
                                @if($food->detail)
                                    <div>
                                        <span class="font-bold">Detail:</span>
                                        <span>{{ $food->detail }}</span>
                                    </div>
                                @endif
                                @if($food->brand)
                                    <div>
                                        <span class="font-bold">Brand:</span>
                                        <span>{{ $food->brand }}</span>
                                    </div>
                                @endif
                                @if(!$food->ingredientAmountRelationships->isEmpty())
                                    <div class="flex space-x-2 items-center text-lg">
                                        <div class="text-yellow-500">
                                            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>Deleting this food will also remove it from the following recipes:</div>
                                    </div>
                                    <ul class="list-disc list-inside ml-3 space-y-1">
                                        @foreach ($food->ingredientAmountRelationships as $ia)
                                            <li> <a class="text-gray-500 hover:text-gray-700"
                                                    href="{{ route('recipes.show', $ia->parent) }}">{{ $ia->parent->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <x-inputs.button class="bg-red-800 hover:bg-red-700">
                            Yes, delete
                        </x-inputs.button>
                        <a class="ml-3 text-gray-500 hover:text-gray-700" href="{{ route('foods.show', $food) }}">
                            No, do not delete</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
