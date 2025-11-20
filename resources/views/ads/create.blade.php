<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить объявление</h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <input type="text" name="name" placeholder="Название" class="w-full border p-2 rounded" required>
                <input type="number" name="price" placeholder="Цена" class="w-full border p-2 rounded">

{{--                <input type="text" name="brand" placeholder="Марка" class="w-full border p-2 rounded">--}}
{{--                <input type="text" name="model" placeholder="Модель" class="w-full border p-2 rounded">--}}
                <div>
                    <label for="year" class="block font-medium">Год выпуска</label>
                    <select name="year" id="year" class="w-full border p-2 rounded">
                        <option value="">Выберите год</option>
                        @for ($y = date('Y'); $y >= 1980; $y--)
                            <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <textarea name="description" placeholder="Описание" class="w-full border p-2 rounded"></textarea>

                <label for="city" class="block font-medium">Город</label>
                <select name="city" id="city" required class="w-full border p-2 rounded">
                    @foreach(\App\Enums\City::cases() as $cityOption)
                        <option value="{{ $cityOption->value }}" {{ old('city') == $cityOption->value ? 'selected' : '' }}>
                            {{ $cityOption->value }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="address" placeholder="Адрес" class="w-full border p-2 rounded">
                <input type="text" name="phone" placeholder="Телефон" class="w-full border p-2 rounded" required>

                <div>
                    <label>Как с вами связаться?</label>
                    <select name="type_call" class="w-full border p-2 rounded" required>
                        <option value="call">Звонок</option>
                        <option value="whatsapp">WhatsApp</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-1">Фотографии (до 6 штук)</label>
                    <input type="file" name="images[]" multiple class="w-full border p-2 rounded" accept="image/*">
                    <p class="text-sm text-gray-500 mt-1">Вы можете загрузить до 6 фотографий.</p>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Сохранить</button>
            </form>
        </div>
    </div>
</x-app-layout>
