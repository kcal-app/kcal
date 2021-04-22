<x-app-layout>
    @php($title = ($user->exists ? "Edit {$user->name}" : 'Add User'))
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $title }}</h1>
    </x-slot>
    <form method="POST" enctype="multipart/form-data" action="{{ ($user->exists ? route('users.update', $user) : route('users.store')) }}">
        @if ($user->exists)@method('put')@endif
        @csrf
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                @include('users.partials.inputs.username')
                @include('users.partials.inputs.name')
            </div>

            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                @include('users.partials.inputs.password')
            </div>

            @include('users.partials.inputs.admin')

            <!-- Image -->
            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                <x-inputs.image :model="$user" preview_name="icon" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inputs.button>{{ ($user->exists ? 'Save' : 'Add') }}</x-inputs.button>
        </div>
    </form>
</x-app-layout>
