<x-guest-layout>
    <form method="POST" action="{{ route('auth.send.code') }}">
        @csrf

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Checkbox согласия -->
        <div class="mt-4 flex items-start">
            <input id="agreement" name="agreement" type="checkbox"
                   class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" required>
            <label for="agreement" class="ml-2 text-sm text-gray-600">
                Я принимаю условия
                <a href="/terms-of-use.txt" target="_blank" class="text-blue-600 underline">
                    Пользовательского соглашения
                </a> и
                <a href="/privacy-policy.txt" target="_blank" class="text-blue-600 underline">
                    Политики конфиденциальности
                </a>.
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Войти / Зарегистрироваться') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
