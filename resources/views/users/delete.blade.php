<x-app-layout>
    <x-slot name="title">Delete {{ $user->name }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Delete {{ $user->name }}?
        </h1>
    </x-slot>
    <form method="POST" action="{{ route('users.destroy', $user) }}">
        @method('delete')
        @csrf
        <div class="pb-3">
            <div class="text-lg">Are you sure what to delete <span class="font-extrabold">{{ $user->name }}</span>?</div>
        </div>
        <x-inputs.button class="bg-red-800 hover:bg-red-700">
            Yes, delete
        </x-inputs.button>
        <a class="ml-3 text-gray-500 hover:text-gray-700" href="{{ route('users.index') }}">
            No, do not delete</a>
    </form>
</x-app-layout>
