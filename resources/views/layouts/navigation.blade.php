<nav x-data="{ open: false }"
     class="sticky top-0 z-40 bg-white/90 dark:bg-gray-900/80 backdrop-blur border-b border-gray-200/70 dark:border-gray-700/60 shadow-sm">

    {{-- Accent bar merah tipis di paling atas --}}
    <div class="h-0.5 w-full bg-gradient-to-r from-red-700 via-red-500 to-red-600"></div>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Kiri: Logo + Links --}}
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center gap-2 rounded-md p-1.5 hover:bg-gray-100/70 dark:hover:bg-gray-800 transition">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        <span class="sr-only">Dashboard</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center">
                    <div class="flex items-stretch gap-1">
                        <div class="relative group">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200
                                       hover:text-red-600 dark:hover:text-red-400 transition">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            {{-- Active indicator bawah --}}
                            @if(request()->routeIs('dashboard'))
                                <span class="absolute left-2 right-2 -bottom-0.5 h-0.5 bg-red-600 rounded-full"></span>
                            @else
                                <span class="pointer-events-none absolute left-2 right-2 -bottom-0.5 h-0.5 bg-red-500/0 group-hover:bg-red-500/70 rounded-full transition"></span>
                            @endif
                        </div>

                        {{-- contoh slot link lain (opsional, aman dihapus) --}}
                        {{-- <div class="relative group">
                            <x-nav-link :href="route('something')" :active="request()->routeIs('something')"
                                class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200
                                       hover:text-red-600 dark:hover:text-red-400 transition">
                                Menu Lain
                            </x-nav-link>
                            @if(request()->routeIs('something'))
                                <span class="absolute left-2 right-2 -bottom-0.5 h-0.5 bg-red-600 rounded-full"></span>
                            @else
                                <span class="pointer-events-none absolute left-2 right-2 -bottom-0.5 h-0.5 bg-red-500/0 group-hover:bg-red-500/70 rounded-full transition"></span>
                            @endif
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- Kanan: Settings / User --}}
            <div class="hidden sm:flex sm:items-center gap-3">

                {{-- Notifikasi (opsional, tidak mengubah fungsi) --}}
                <button type="button"
                        class="relative inline-flex items-center justify-center h-9 w-9 rounded-md
                               text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400
                               hover:bg-gray-100/70 dark:hover:bg-gray-800 transition"
                        aria-label="Notifications">
                    <i class="fa-regular fa-bell text-[18px]"></i>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium
                                   rounded-md text-gray-700 dark:text-gray-200 bg-white/70 dark:bg-gray-800/70
                                   hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition">
                            <div class="hidden sm:block">{{ Auth::user()->name }}</div>
                            <div
                                class="grid place-content-center h-7 w-7 rounded-md bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                <i class="fa-solid fa-user text-[12px]"></i>
                            </div>
                            <div class="ms-1 text-gray-500 dark:text-gray-400">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md
                               text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400
                               hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200/70 dark:border-gray-700/60">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="text-gray-700 dark:text-gray-200 hover:text-red-600 dark:hover:text-red-400">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200/70 dark:border-gray-700/60">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
