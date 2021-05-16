<x-app-layout>
    <x-slot name="title">{{ $goal->name }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight flex flex-auto items-center">
            {{ $goal->name }}
        </h1>
    </x-slot>
    <div class="flex flex-col-reverse justify-between pb-4 md:flex-row md:space-x-4">
        <div class="flex-1">
            <section>
                Default goal <span class="font-bold">{{ $goal->days_formatted->count() }}</span> days per week.
                @if($goal->days_formatted->count() > 1)
                    <ul class="list-disc list-inside pt-2">
                        @foreach($goal->days_formatted->pluck('label') as $day)
                            <li>{{ \Illuminate\Support\Str::ucfirst($day) }}</li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </div>
        <aside class="flex flex-col space-y-4 mt-8 sm:mt-0 sm:max-w-xs">
            <section class="p-1 border-2 border-black font-sans md:w-72">
                <h1 class="text-3xl font-extrabold leading-none border-b-8 border-black">Goals</h1>
                <h2 class="font-bold text-right">Amount per day</h2>
                <section class="flex justify-between items-end font-extrabold">
                    <h1 class="text-3xl">Calories</h1>
                    <div class="text-4xl">{{ number_format($goal->calories) }}</div>
                </section>
                <div class="border-t-4 border-black text-sm">
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Total Fat</h1>
                        <div>{{ number_format($goal->fat) }}g</div>
                    </section>
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Cholesterol</h1>
                        <div>{{ number_format($goal->cholesterol) }}mg</div>
                    </section>
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Sodium</h1>
                        <div>{{ number_format($goal->sodium) }}mg</div>
                    </section>
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Total Carbohydrate</h1>
                        <div>{{ number_format($goal->carbohydrates) }}g</div>
                    </section>
                    <hr class="border-gray-500"/>
                    <section class="flex justify-between">
                        <h1 class="font-bold">Protein</h1>
                        <div>{{ number_format($goal->protein) }}g</div>
                    </section>
                </div>
            </section>
            <section class="flex flex-row space-x-2 justify-around md:flex-col md:space-y-2 md:space-x-0">
                <x-button-link.gray href="{{ route('goals.edit', $goal) }}">
                    Edit Goal
                </x-button-link.gray>
                <x-button-link.red href="{{ route('goals.delete', $goal) }}">
                    Delete Goal
                </x-button-link.red>
            </section>
        </aside>
    </div>
</x-app-layout>
