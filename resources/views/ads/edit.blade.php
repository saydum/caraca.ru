<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать объявление</h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('ads.update', $ad) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <input type="text" name="name" value="{{ old('name', $ad->name) }}" placeholder="Название" class="w-full border p-2 rounded" required>
                <input type="number" name="price" value="{{ old('name', $ad->price) }}" placeholder="Цена" class="w-full border p-2 rounded" required>

{{--                <input type="text" name="brand" value="{{ old('brand', $ad->brand) }}" placeholder="Марка" class="w-full border p-2 rounded">--}}
{{--                <input type="text" name="model" value="{{ old('model', $ad->model) }}" placeholder="Модель" class="w-full border p-2 rounded">--}}
                <div>
                    <label for="year" class="block font-medium">Год выпуска</label>
                    <select name="year" id="year" class="w-full border p-2 rounded" required>
                        <option value="">Выберите год</option>
                        @for ($y = date('Y'); $y >= 1980; $y--)
                            <option value="{{ $y }}" {{ old('year', $ad->year) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>


                <textarea name="description" placeholder="Описание" class="w-full border p-2 rounded">{{ old('description', $ad->description) }}</textarea>

                <div>
                    <label for="city" class="block font-medium">Город</label>
                    <select name="city" id="city" required class="w-full border p-2 rounded">
                        @foreach(\App\Enums\City::cases() as $cityOption)
                            <option value="{{ $cityOption->value }}"
                                {{ old('city', $ad->city) === $cityOption->value ? 'selected' : '' }}>
                                {{ $cityOption->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="text" name="address" value="{{ old('address', $ad->address) }}" placeholder="Адрес" class="w-full border p-2 rounded">
                <input type="text" name="phone" value="{{ old('phone', $ad->phone) }}" placeholder="Телефон" class="w-full border p-2 rounded" required>

                <div>
                    <label>Как с вами связаться?</label>
                    <select name="type_call" class="w-full border p-2 rounded" required>
                        @foreach (\App\Enums\TypeCall::cases() as $type)
                            <option value="{{ $type->value }}" {{ old('type_call', $ad->type_call) === $type->value ? 'selected' : '' }}>
                                {{ ucfirst($type->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="file" name="images[]" multiple class="w-full">

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Сохранить</button>
            </form>
        </div>
    </div>
</x-app-layout>
