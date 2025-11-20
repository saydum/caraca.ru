<x-guest-layout>
    <form method="POST" action="{{ route('auth.login') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mt-4">
            <x-input-label for="code" :value="__('Введите код, придет на вашу почту')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Войти') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
