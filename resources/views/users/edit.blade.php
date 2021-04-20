<x-app-layout>
    @php($title = ($user->exists ? "Edit {$user->name}" : 'Add User'))
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $title }}</h1>
    </x-slot>
    <form method="POST" action="{{ ($user->exists ? route('users.update', $user) : route('users.store')) }}">
        @if ($user->exists)@method('put')@endif
        @csrf
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
                <!-- Username -->
                <div class="flex-auto">
                    <x-inputs.label for="username" value="Username"/>

                    <x-inputs.input name="username"
                                    type="text"
                                    class="block mt-1 w-full"
                                    autocapitalize="none"
                                    :value="old('username', $user->username)"
                                    :hasError="$errors->has('username')"
                                    required />
                </div>

                <!-- Name -->
                <div class="flex-auto">
                    <x-inputs.label for="name" value="Name"/>

                    <x-inputs.input name="name"
                                    type="text"
                                    class="block mt-1 w-full"
                                    :value="old('name', $user->name)"/>
                </div>

                <!-- Password -->
                <div>
                    <x-inputs.label for="password" value="Password"/>

                    <x-inputs.input name="password"
                                    type="password"
                                    class="block mt-1 w-full"
                                    :hasError="$errors->has('password')"
                                    :required="!$user->exists"/>
                </div>

                <!-- Password confirm -->
                <div>
                    <x-inputs.label for="password_confirmation" value="Confirm Password"/>

                    <x-inputs.input name="password_confirmation"
                                    type="password"
                                    class="block mt-1 w-full"
                                    :hasError="$errors->has('password')"
                                    :required="!$user->exists"/>
                </div>

                <!-- Admin -->
                <div>
                    <x-inputs.label for="admin" value="Site Admin"/>

                    <x-inputs.input name="admin"
                                    type="checkbox"
                                    value="1"
                                    :checked="old('admin', $user->admin)" />
                </div>

            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inputs.button>{{ ($user->exists ? 'Save' : 'Add') }}</x-inputs.button>
        </div>
    </form>
</x-app-layout>
