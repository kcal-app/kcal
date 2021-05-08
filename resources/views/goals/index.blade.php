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
    <table class="min-w-max w-full table-auto">
        <thead>
        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th class="py-3 px-6 text-left">Name</th>
            <th class="py-3 px-6 text-left">Days of Week</th>
            <th class="py-3 px-6 text-left">Goals</th>
            <th class="py-3 px-6 text-left">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($goals as $goal)
            <tr class="border-b border-gray-200">
                <td class="py-3 px-6">{{ $goal->name }}</td>
                <td class="py-3 px-6">{{ $goal->days }}</td>
                <td class="py-3 px-6">
                    Calories: {{ $goal->calories }}<br />
                    Carbohydrates: {{ $goal->carbohydrates }}<br />
                    Cholesterol: {{ $goal->cholesterol }}<br />
                    Fat: {{ $goal->fat }}<br />
                    Protein: {{ $goal->Protein }}<br />
                    Sodium: {{ $goal->sodium }}<br />
                </td>
                <td class="py-3 px-6">
                    <div class="flex space-x-2 justify-end">
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
