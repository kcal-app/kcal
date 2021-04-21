<x-app-layout>
    <x-slot name="title">Users</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-2xl text-gray-800 leading-tight">Users</h1>
            <x-button-link.green href="{{ route('users.create') }}">
                Add User
            </x-button-link.green>
        </div>
    </x-slot>
    <table class="min-w-max w-full table-auto">
        <thead>
        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th class="py-3 px-6 text-left">Username</th>
            <th class="py-3 px-6 text-left">Name</th>
            <th class="py-3 px-6 text-left">Photo</th>
            <th class="py-3 px-6 text-left">Admin</th>
            <th class="py-3 px-6 text-left">Created</th>
            <th class="py-3 px-6 text-left">Updated</th>
            <th class="py-3 px-6 text-left">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="border-b border-gray-200">
                <td class="py-3 px-6">{{ $user->username }}</td>
                <td class="py-3 px-6">{{ $user->name }}</td>
                <td class="py-3 px-6">
                    <x-user-icon :user="$user" />
                </td>
                <td class="py-3 px-6">@if($user->admin) Yes @else No @endif</td>
                <td class="py-3 px-6">{{ $user->created_at }}</td>
                <td class="py-3 px-6">{{ $user->updated_at }}</td>
                <td class="py-3 px-6">
                    <div class="flex space-x-2 justify-end">
                        <x-button-link.gray href="{{ route('users.edit', $user) }}">
                            Edit
                        </x-button-link.gray>
                        @can('delete', $user)
                            <x-button-link.red href="{{ route('users.delete', $user) }}">
                                Delete
                            </x-button-link.red>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-app-layout>
