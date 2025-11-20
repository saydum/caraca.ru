<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Validation\Rule;
use Leeto\Seo\Models\Seo;
use Leeto\Seo\Rules\UrlRule;
use MoonShine\Laravel\Handlers\Handler;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class SeoResource extends ModelResource
{
    protected string $model = Seo::class;

    protected string $title = 'Seo';

    protected string $column = 'title';

    protected bool $detailInModal = true;

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Url')
                    ->required(),
                Text::make('Title')
                    ->required(),
                Text::make('Description'),
                Text::make('Keywords'),
                Textarea::make('Text'),
            ])
        ];
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()
                ->sortable(),
            Text::make('Url'),
            Text::make('Title'),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Url'),
            Text::make('Title'),
            Text::make('Description'),
            Text::make('Keywords'),
            Textarea::make('Text')
        ];
    }

    protected function exportFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Url'),
            Text::make('Title'),
            Text::make('Description'),
            Text::make('Keywords'),
        ];
    }

    protected function importFields(): iterable
    {
        return $this->exportFields();
    }

    protected function rules($item): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3'
            ],
            'url' => [
                'required',
                'string',
                new UrlRule,
                Rule::unique('seo')->ignoreModel($item)
            ]
        ];
    }

    public function search(): array
    {
        return ['id', 'url', 'title'];
    }

    public function filters(): array
    {
        return [
            Text::make('Url'),
            Text::make('Title'),
        ];
    }

    public function indexButtons(): ListOf
    {
        return parent::indexButtons()->add(
            ActionButton::make('На страницу', static fn (Seo $item) => $item->url)
                ->icon('arrow-top-right-on-square')
                ->blank()
        );
    }
}
