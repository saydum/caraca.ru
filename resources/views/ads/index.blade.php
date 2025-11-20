<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Мои объявления
        </h2>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto">
        @if($ads->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ads as $ad)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <img class="h-48 w-full object-cover"
                             src="{{ asset('storage/' . ($ad->images[0] ?? 'placeholder.png')) }}"
                             alt="{{ $ad->name }}">

                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $ad->name }}</h3>
                            <p class="text-gray-600 mb-2">{{ $ad->description }}</p>
                            <p class="text-gray-500 text-sm mb-2">Создан: {{ $ad->created_at->format('d.m.Y') }}</p>

                            {{-- Статус модерации --}}
                            @if($ad->moderation_status === 'pending')
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded">
                                    На проверке
                                </span>
                            @elseif($ad->moderation_status === 'approved')
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded">
                                    Одобрено
                                </span>
                            @elseif($ad->moderation_status === 'rejected')
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">
                                    Отклонено
                                </span>
                            @endif

                            <div class="flex space-x-2 justify-center pl-2 pr-2 mt-3">
                                <a href="{{ route('ads.edit', $ad->id) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Редактировать</a>

                                <form action="{{ route('ads.archive', $ad->id) }}" method="POST" onsubmit="return confirm('Удалить объявление?')">
                                    @csrf
                                    @method('POST')
                                    <button type="submit"
                                            class="px-3 whitespace-nowrap py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Снять с публикации
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $ads->links() }}
            </div>

        @else
            <p class="text-center text-gray-600">У вас пока нет объявлений.</p>
        @endif
    </div>
</x-app-layout>
