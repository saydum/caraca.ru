<x-app-layout>
    <x-slot name="header">
        {{-- Этот блок я оставил без изменений --}}
        <div class="flex items-center justify-center gap-4 w-full">
            <form method="GET" action="{{ route('app') }}" class="flex items-center gap-4 w-full">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <input type="hidden" name="city" value="{{ request('city') }}">
                <div x-data="{ open: false }" class="relative">
                    <button type="button"
                            @click="open = !open"
                            class="px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100">
                        <i class="bi bi-arrow-down-up"></i>
                    </button>
                    <div x-show="open"
                         @click.away="open = false"
                         class="absolute z-10 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg" x-cloak>
                        <button type="submit" name="sort" value="date"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                            По дате
                        </button>
                        <button type="submit" name="sort" value="year"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                            По году
                        </button>
                        <button type="submit" name="sort" value="price_asc"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                            Цена ↑
                        </button>
                        <button type="submit" name="sort" value="price_desc"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                            Цена ↓
                        </button>
                    </div>
                </div>
                <div class="relative flex-1 w-full text-start">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Поиск объявлений..."
                           class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
                    <button type="submit"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
                        </svg>
                    </button>
                </div>
            </form>

            <a href="{{ route('app.ads.create') }}"
               class="
                  shrink-0 px-4 py-2.5 sm:px-6 sm:py-3 text-sm sm:text-base
                  font-medium text-white bg-blue-600 hover:bg-blue-700
                  rounded-lg transition duration-200 whitespace-nowrap text-center
               "
            >
                Добавить объявление
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">

                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                        @forelse ($ads as $ad)
                            <a href="{{ route('ads.show', $ad->slug) }}"
                               class="bg-gray-50 border border-gray-200 rounded-lg shadow hover:shadow-md transition overflow-hidden flex flex-col">

                                @if(!empty($ad->images) && count($ad->images) > 0)
                                    <img class="w-full h-36 sm:h-48 object-cover"
                                         src="{{ asset('storage/' . $ad->images[0]) }}"
                                         alt="{{ $ad->name }}" />
                                @else
                                    <img class="w-full h-36 sm:h-48 object-cover"
                                         src="https://via.placeholder.com/300x200"
                                         alt="{{ $ad->name }}" />
                                @endif

                                <div class="p-3 sm:px-4 sm:py-5 flex flex-col flex-grow justify-between">
                                    <div>
                                        <h5 class="mb-1 text-sm sm:text-base font-semibold text-gray-900 line-clamp-2">
                                            {{ $ad->name }}
                                        </h5>
                                        <p class="text-xs sm:text-sm text-gray-800 font-medium mb-1">
                                            {{ $ad->price ? number_format($ad->price, 0, '', ' ') . ' руб' : 'Цена по запросу' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mb-1">
                                            {{ $ad->city ?? 'Город не указан' }}
                                        </p>
                                        <p class="text-xs sm:text-sm text-gray-700 mt-1 sm:mt-2 hidden sm:block line-clamp-3">
                                            {{ \Illuminate\Support\Str::limit($ad->description, 80) }}
                                        </p>
                                    </div>

                                    <p class="text-xs text-gray-400 pt-2">
                                        {{ $ad->created_at->format('d.m.Y') }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="text-center col-span-full flex justify-center items-center py-12">
                                <p class="text-gray-500 text-lg">
                                    Объявлений не найдено.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $ads->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
