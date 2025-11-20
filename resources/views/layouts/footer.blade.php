<footer class="bg-gray-100 text-gray-700">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">

            <!-- Логотип / название -->
            <a href="{{ route('app') }}" class="flex items-center text-xl font-bold text-gray-900">
                <i class="bi bi-car-front-fill mr-2"></i>
                caraca.ru
            </a>

            <!-- Навигация -->
            <div class="flex flex-wrap justify-center md:justify-end gap-4">
                <a href="{{ route('app') }}" class="hover:text-blue-600 transition">Главная</a>
                <a href="{{ route('ads.create') }}" class="hover:text-blue-600 transition">Добавить объявление</a>
                <a href="{{ route('app') }}" class="hover:text-blue-600 transition">Контакты</a>
            </div>
        </div>

        <!-- Политика и копирайт -->
        <div class="mt-6 text-center text-sm text-gray-500 space-y-1">
            <p>
                Используя наш сайт, вы автоматически соглашаетесь с
                <a href="/privacy-policy.txt" class="underline hover:text-blue-600" target="_blank">
                    Политикой конфиденциальности
                </a> и
                <a href="/terms-of-use.txt" class="underline hover:text-blue-600" target="_blank">
                    Пользовательским соглашением
                </a>.
            </p>
            <p>&copy; {{ date('Y') }} caraca.ru. Все права защищены.</p>
        </div>
    </div>
</footer>
