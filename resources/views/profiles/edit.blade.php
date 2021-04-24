<x-app-layout>
    <x-slot name="title">Edit Profile</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">Edit Profile</h1>
    </x-slot>
    <form method="POST" enctype="multipart/form-data" action="{{ route('profiles.update', $user) }}">
        @method('put')
        @csrf
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                @include('users.partials.inputs.username')
                @include('users.partials.inputs.name')
            </div>

            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                @include('users.partials.inputs.password')
            </div>

            <!-- Image -->
            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                <x-inputs.image :model="$user" preview_name="icon" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inputs.button>Save</x-inputs.button>
        </div>
    </form>
</x-app-layout>
