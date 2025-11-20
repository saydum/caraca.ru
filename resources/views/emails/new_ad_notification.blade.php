<h2>Новое объявление добавлено на сайт</h2>

<p><strong>Название:</strong> {{ $ad->name }}</p>
<p><strong>Цена:</strong> {{ $ad->price }} руб.</p>
<p><strong>Город:</strong> {{ $ad->city }}</p>
<p><strong>Телефон:</strong> {{ $ad->phone }}</p>
<p><strong>Описание:</strong> {{ $ad->description }}</p>

<p>
    <a href="{{ route('ads.show', $ad->slug) }}">
        👉 Посмотреть объявление
    </a>
</p>
