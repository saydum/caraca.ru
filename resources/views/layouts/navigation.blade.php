<nav x-data="{ open: false, cityOpen: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('app') }}" class="text-xl font-medium flex items-center">
                        <i class="bi bi-car-front-fill mr-1"></i>
                        caraca.ru
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = true" class="flex items-center px-3 py-2 rounded-lg text-gray-600 hover:text-blue-600">
                        <i class="bi bi-geo-alt mr-1"></i>
                        <span>{{ request('city') ?: 'Все города' }}</span>
                    </button>
                    <div x-show="open" x-cloak @click.away="open = false"
                         class="absolute z-50 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg">
                        <a href="{{ route('app') }}"
                           class="block px-4 py-2 hover:bg-gray-100 {{ request('city') ? '' : 'bg-blue-100 font-semibold' }}">
                            Все города
                        </a>
                        @foreach(\App\Enums\City::cases() as $cityOption)
                            <a href="{{ route('app', ['city' => $cityOption->value]) }}"
                               class="block px-4 py-2 hover:bg-gray-100 {{ request('city') == $cityOption->value ? 'bg-blue-100 font-semibold' : '' }}">
                                {{ $cityOption->value }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('app') }}" class="px-3 py-2 rounded-lg hover:bg-gray-100">
                    Все объявления
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @auth
                                <div>{{ Auth::user()->name }}</div>
                            @else
                                <div>Гость</div>
                            @endauth

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @auth
                            <x-dropdown-link :href="route('ads.index')">Мои объявления</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">Мои данные</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Выйти
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('auth.email.form')">Зарегистрироваться</x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = true" class="flex items-center px-3 py-2 rounded-lg text-gray-600 hover:text-blue-600">
                        <i class="bi bi-geo-alt mr-1"></i>
                        <span>{{ request('city') ?: 'Все города' }}</span>
                    </button>
                    <div x-show="open" x-cloak @click.away="open = false"
                         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
                            <h2 class="text-lg font-semibold mb-4">Выберите город</h2>
                            <div class="grid grid-cols-2 gap-3 max-h-80 overflow-y-auto">
                                <a href="{{ route('app') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request('city') ? '' : 'bg-blue-100 font-semibold' }}">
                                    Все города
                                </a>
                                @foreach(\App\Enums\City::cases() as $cityOption)
                                    <a href="{{ route('app', ['city' => $cityOption->value]) }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request('city') == $cityOption->value ? 'bg-blue-100 font-semibold' : '' }}">
                                        {{ $cityOption->value }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="mt-4 text-right">
                                <button @click="open = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                    Закрыть
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('app')" :active="request()->routeIs('app')">
                Все объявления
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('ads.index')">
                        Мои объявления
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Мои данные
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            Выйти
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('auth.email.form')">
                        Зарегистрироваться
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
