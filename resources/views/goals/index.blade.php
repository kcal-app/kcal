<x-app-layout>
    <x-slot name="title">My Goals</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-2xl text-gray-800 leading-tight">My Goals</h1>
            <x-button-link.green href="{{ route('goals.create') }}" class="text-sm">
                Add Goal
            </x-button-link.green>
        </div>
    </x-slot>
    <table class="w-full table-fixed">
        <thead>
        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th class="py-3 px-6 text-left">Name</th>
            <th class="hidden py-3 px-6 text-left lg:table-cell">Days of Week</th>
            <th class="hidden py-3 px-6 text-left sm:table-cell">Total Calories</th>
            <th class="py-3 px-6 text-left">Operations</th>
        </tr>
        </thead>
        <tbody>
        @foreach($goals as $goal)
            <tr class="border-b border-gray-200">
                <td class="py-3 px-6">
                    <a class="text-gray-500 hover:text-gray-700 hover:border-gray-300"
                       href="{{ route('goals.show', $goal) }}">
                        {{ $goal->name }}
                    </a>
                </td>
                <td class="hidden py-3 px-6 lg:table-cell">
                    @empty($goal->days_formatted->count())
                        <em>none</em>
                    @else
                        {{ $goal->days_formatted->pluck('label')->join(', ') }}
                    @endempty
                </td>
                <td class="hidden py-3 px-6 sm:table-cell">
                    {{ number_format($goal->calories) }}
                </td>
                <td class="py-3 px-6">
                    <div class="flex flex-col space-y-2 justify-start sm:flex-row sm:space-x-2 sm:space-y-0">
                        <x-button-link.gray href="{{ route('goals.edit', $goal) }}">
                            Edit
                        </x-button-link.gray>
                        <x-button-link.red href="{{ route('goals.delete', $goal) }}">
                            Delete
                        </x-button-link.red>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-app-layout>
