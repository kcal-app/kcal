<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex space-x-8">
                    <x-nav-link :href="route('journal-entries.index')" :active="request()->routeIs('journal-entries.*')" title="Journal">
                        Journal
                    </x-nav-link>
                    <x-nav-link :href="route('recipes.index')" :active="request()->routeIs('recipes.*')" title="Recipes">
                        Recipes
                    </x-nav-link>
                    <x-nav-link :href="route('foods.index')" :active="request()->routeIs('foods.*')" title="Foods">
                        Foods
                    </x-nav-link>
                </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <x-user-icon :user="Auth::user()" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="space-y-2">
                            <x-dropdown-link :href="route('profiles.show', Auth::user())">My Profile</x-dropdown-link>
                            <x-dropdown-link :href="route('goals.index')">My Goals</x-dropdown-link>
                            @can('administer', \App\Models\User::class)
                                <hr />
                                <x-dropdown-link :href="route('users.index')">Manage Users</x-dropdown-link>
                            @endcan
                            <hr />
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link :href="route('logout')" @click.prevent="$el.closest('form').submit();">Logout</x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
