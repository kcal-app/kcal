<x-app-layout>
    @php($title = ($user->id === Auth::user()->id ? 'My Profile': "{$user->name}'s  Profile"))
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-2xl text-gray-800 leading-tight">{{ $title }}</h1>
            @can('editProfile', $user)
                <x-button-link.green href="{{ route('profiles.edit', $user) }}" class="text-sm">
                    Edit Profile
                </x-button-link.green>
            @endcan
        </div>
    </x-slot>
    @if($user->hasMedia())
        <div class="inline-block">
            <a href="{{ $user->getFirstMedia()->getFullUrl() }}" target="_blank">
                {{ $user->getFirstMedia()('icon') }}
            </a>
        </div>
        <div class="mt-2 text-gray-500">
            {{ $user->name }}
        </div>
    @endif
</x-app-layout>
