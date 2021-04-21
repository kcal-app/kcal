<x-app-layout>
    <x-slot name="title">Profile</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-2xl text-gray-800 leading-tight">Profile</h1>
        </div>
    </x-slot>
    {{ $user->name }}
</x-app-layout>
