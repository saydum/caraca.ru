<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ads;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Badge;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Ads>
 */
class AdsResource extends ModelResource
{
    protected string $model = Ads::class;

    protected string $title = 'Объявления';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Text::make('Email', 'user.email', fn($ad) => $ad->user?->email),
            Number::make('Цена', 'price'),
            Date::make('Опубликован', 'created_at')->format('d.m.Y H:i'),
            Text::make('Статус', 'status'),
            Select::make('Модерация', 'moderation_status')
                ->options([
                    'pending' => '⏳ На проверке',
                    'approved' => '✅ Одобрено',
                    'rejected' => '❌ Отклонено',
                ])
                ->updateOnPreview() // редактируем в списке
                ->badge(fn($value) => match($value) {
                    'approved' => Badge::make('Одобрено')->success(),
                    'rejected' => Badge::make('Отклонено')->error(),
                    default => Badge::make('На проверке')->warning(),
                }),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    /**
     * @param Ads $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
