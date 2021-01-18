<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Delete {{ $food->name }}?
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('foods.destroy', $food) }}">
                        @method('delete')
                        @csrf
                        <div class="text-lg pb-3">
                            Are you sure what to delete <span class="font-extrabold">{{ $food->name }}</span>?
                            <div class="grid grid-cols-2 w-max">
                                <div class="font-bold pr-2">Detail:</div>
                                <div>{{ $food->detail ?? 'None' }}</div>
                                <div class="font-bold pr-2">Brand:</div>
                                <div>{{ $food->brand ?? 'None' }}</div>
                            </div>
                        </div>
                        <x-inputs.button class="bg-red-800 hover:bg-red-700">
                            Yes, delete
                        </x-inputs.button>
                        <a class="ml-3 text-gray-500 hover:text-gray-700 hover:border-gray-300"
                           href="{{ route('foods.show', $food) }}">No, do not delete</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
