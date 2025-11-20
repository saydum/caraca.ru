<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $ad->name }}</h2>
            <button onclick="history.back()" class="btn btn">← Назад</button>
        </div>
    </x-slot>

    <div class="py-12" x-data="adPage({{ json_encode(array_map(fn($path) => asset('storage/' . $path), $ad->images ?? [])) }})">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Галерея --}}
                <div class="w-full">
                    <div class="relative w-full h-96 rounded-lg overflow-hidden cursor-pointer" @click="openModal = true">
                        <img :src="activeImage" class="w-full h-full object-cover" :alt="'Фото ' + (activeIndex + 1)">
                    </div>

                    <div class="flex mt-4 space-x-2 justify-center">
                        <template x-for="(image, index) in images" :key="index">
                            <button type="button"
                                    class="w-20 h-20 border rounded overflow-hidden"
                                    :class="{'ring-2 ring-blue-500': activeIndex === index}"
                                    @click="setActive(index)">
                                <img :src="image" class="w-full h-full object-cover" :alt="'Фото ' + (index + 1)">
                            </button>
                        </template>
                    </div>

                    <div x-show="openModal"
                         class="fixed inset-0 z-50 bg-black bg-opacity-80" x-cloak
                         @keydown.escape.window="openModal = false"
                         @keydown.arrow-left.window="prev"
                         @keydown.arrow-right.window="next"
                    >
                        <div class="w-full h-full flex items-center justify-center p-4 sm:p-8" @click.self="openModal = false">
                            <img :src="activeImage"
                                 class="max-w-full max-h-full object-contain rounded-lg shadow-lg"
                                 :alt="'Фото ' + (activeIndex + 1)">
                        </div>

                        <button @click="openModal = false"
                                class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 transition">&times;</button>

                        <button @click="prev"
                                x-show="images.length > 1"
                                class="absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 p-2 bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        <button @click="next"
                                x-show="images.length > 1"
                                class="absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 p-2 bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Основная информация --}}
                <h1 class="text-2xl font-bold mt-6 mb-4">{{ $ad->name }}</h1>
                <p class="text-lg font-semibold text-gray-700 mb-4">
                    {{$ad->price
                        ? 'Цена ' . number_format($ad->price, 0, '', ' ') . ' руб'
                        : 'Цена не указана'}}
                </p>
                <p class="text-gray-600 mb-6">{{ $ad->description }}</p>
                <p class="text-sm text-gray-500 mb-4">Опубликовано: {{ $ad->created_at->format('d.m.Y H:i') }}</p>

                {{-- Контактные кнопки --}}
                @auth
                    @if($ad->type_call === 'call')
                        <button onclick="window.location.href='tel:{{ $ad->phone }}'"
                                class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Позвонить
                        </button>
                    @elseif($ad->type_call === 'whatsapp')
                        <button onclick="window.location.href='https://wa.me/{{ preg_replace('/\D/', '', $ad->phone) }}'"
                                class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            WhatsApp
                        </button>
                    @endif

                    {{-- Кнопка Пожаловаться --}}
                    <button @click="openComplaint = true"
                            class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 mt-4">
                        Пожаловаться
                    </button>
                @endauth

                @guest
                    <a href="{{ route('auth.email.form') }}"
                       class="inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Зарегистрируйтесь, чтобы связаться
                    </a>
                @endguest

                {{-- Модальное окно жалобы --}}
                <div x-show="openComplaint"
                     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                     x-cloak
                     @keydown.escape.window="openComplaint = false">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md relative">
                        <h2 class="text-xl font-bold mb-4">Отправить жалобу</h2>
                        <form method="POST" action="{{ route('ads.complaint', $ad->id) }}">
                            @csrf
                            <textarea name="complaint_text" x-model="complaintText"
                                      placeholder="Опишите проблему с этим объявлением"
                                      class="w-full border rounded p-2 mb-4" rows="4" required></textarea>
                            <div class="flex justify-end space-x-2">
                                <button type="button" @click="openComplaint = false"
                                        class="px-4 py-2 bg-gray-400 rounded hover:bg-gray-500 text-white">
                                    Отмена
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 rounded hover:bg-red-700 text-white">
                                    Отправить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Alpine.js скрипт --}}
    <script>
        function adPage(images) {
            return {
                images: images || [],
                activeIndex: 0,
                activeImage: images?.[0] || '',
                openModal: false,

                openComplaint: false,
                complaintText: '',

                setActive(index) {
                    this.activeIndex = index;
                    this.activeImage = this.images[index];
                },
                prev() {
                    if (!this.images || this.images.length === 0) return;
                    this.activeIndex = (this.activeIndex - 1 + this.images.length) % this.images.length;
                    this.activeImage = this.images[this.activeIndex];
                },
                next() {
                    if (!this.images || this.images.length === 0) return;
                    this.activeIndex = (this.activeIndex + 1) % this.images.length;
                    this.activeImage = this.images[this.activeIndex];
                }
            }
        }
    </script>

</x-app-layout>
